<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelHasPermission;
use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberUpdateRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Session;
use DB;
use App\User;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index(Request $request) {
        $query = User::query();

        if ($request->has('key')) {
            $query = $query->where('name', 'like', '%'.$request->key.'%');
        }

        $query->where('id', '<>', 1);

        $members = $query->paginate(10);

        $viewData = [
            'members' => $members,
            'key' => $request->key,
        ];

        return view("admin.member.index", $viewData);
    }

    public function create() {
        $roles = Role::get();
        $permissions = Permission::all();

        return view('admin.member.create', compact('roles', 'permissions'));
    }

    public function store(MemberCreateRequest $request) {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['code'] = 'NV';
            $user = User::create(array_merge($data, [
                'password' => bcrypt($data['password'])
            ]));

            $user->update([
                'code' => 'NV'.str_pad($user->id, 4, '0', STR_PAD_LEFT)
            ]);

            if (isset($request['roles'])) {
                foreach ($request['roles'] as $role) {
                    $roleOld = Role::where('id', '=', $role)->firstOrFail();
                    $user->assignRole($roleOld);
                }
            }
            
            if (isset($request['permissions'])) {
                foreach ($request['permissions'] as $value) {
                    $permissionOld = Permission::where('id', '=', $value)->first();
                    $user->givePermissionTo($permissionOld);
                }
            }
            DB::commit();
            return redirect()->route('admin.member.index')->with('alert-success','T???o th??nh vi??n th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-danger','T???o th??nh vi??n th???t b???i!');
        }
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $roles = Role::get();
        $permissions = Permission::all();
        $permissionOfRole = $user->roles->load('permissions')->pluck('id')->toArray();
        $listPermissionOfRole = [];
        foreach ($permissionOfRole as $value) {
            $listPermissionOfRole = Role::find($value)->permissions->pluck('id')->toArray();
        }
        return view('admin.member.edit', compact('user', 'roles', 'permissions', 'listPermissionOfRole'));
    }

    public function update(MemberUpdateRequest $request, $id) {
        try {
            $user = User::findOrFail($id);
            $input = $request->only(['name', 'email']);
            $data = $request->all();
            $roles = $request['roles'];
            $user->syncRoles($roles); 
            if(isset($data['roles'])){
                foreach ($data['roles'] as $value) {
                    $role = Role::find($value);
                    $user->assignRole($role->name);
                }
            }

            ModelHasPermission::where("model_id", $id)->delete(); 
            if(isset($data['permissions'])){
                foreach ($data['permissions'] as $value) {
                    $permission = Permission::find($value);
                    $user->givePermissionTo($permission->name);
                }
            }

            $data = array_merge($request->all(), [
                'password' => bcrypt($data['password'])
            ]);
            $user->update($data);
            return redirect()->route('admin.member.index')->with('alert-success','C???p nh???t th??ng tin th??nh vi??n th??nh c??ng!');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'C???p nh???t th??ng tin th??nh vi??n th???t b???i!');
        }
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->syncPermissions();
        $user->syncRoles();
        $user->delete();
        return redirect()->route('admin.member.index')->with('alert-success', 'X??a th??nh vi??n th??nh c??ng!');
    }

    public function profile() {
        return view('admin.member.profile');
    }

    public function updateProfile(MemberUpdateRequest $request) {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $input = $request->only(['name', 'email']);
            $data = $request->all();

            $data = array_merge($request->all(), [
                'password' => bcrypt($data['password'])
            ]);
            $user->update($data);
            return redirect()->back()->with('alert-success','C???p nh???t th??ng tin c?? nh??n th??nh c??ng!');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'C???p nh???t th??ng tin c?? nh??n th???t b???i!');
        }
    }
}
