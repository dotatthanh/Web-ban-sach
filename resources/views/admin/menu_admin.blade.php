<button class="fa fa-bars btn-menu-admin"></button>
<header class="menu-admin">
	<button class="fa fa-arrow-left btn-close-admin"></button>
    <ul>
    	<li><a href="#" class="lili">Quản lý</a>
    		<ul>
                <li><a href="{{ route('warehouses.index') }}">Nhập hàng</a></li>
    			<li><a href="{{ route('orders.index') }}">Đơn đặt hàng</a></li>
                <li><a href="{{ route('orders.sales-orders') }}">Đơn bán hàng</a></li>
                <li><a href="{{ route('return-order.index') }}">Đơn hàng trả lại</a></li>
    			<li><a href="{{ route('types.index') }}">Thể loại</a></li>
    			<li><a href="{{ route('categorys.index') }}">Danh mục</a></li>
    			<li><a href="{{ route('authors.index') }}">Tác giả</a></li>
    			<li><a href="{{ route('books.index') }}">Sách</a></li>
    			<li><a href="{{ route('news.index') }}">Tin tức</a></li>
                <li><a href="">Nhà cung cấp</a></li>
                <li><a href="{{ route('pages.customer.index') }}">Khách hàng</a></li>
                <li><a href="{{ route('admin.member.index') }}">Nhân viên</a></li>
                <li><a href="{{ route('admin.role.index') }}">Vai trò</a></li>
                <li><a href="{{ route('admin.permission.index') }}">Quyền</a></li>
    		</ul>
    	</li>
    	<li><a href="#" class="lili">Thống kê</a>
    		<ul>
                <li><a href="{{ route('book-statistic') }}">Kho sách</a></li>
                <li><a href="">Sách đã bán</a></li>
                <li><a href="{{ route('staff-revenue') }}">Doanh thu nhân viên</a></li>
    			{{-- <li><a href="{{ route('contacts.index') }}">Phản hồi</a></li> --}}
    		</ul>
    	</li>
        <li>
            <a href="{{ route('admin.profile') }}">
                Thông tin cá nhân
            </a>
        </li>
    	<li>
            <a href="{{ route('logout') }}" onclick="
                event.preventDefault();
                document.getElementById('logout-form').submit();">
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    	
    </ul>
</header>