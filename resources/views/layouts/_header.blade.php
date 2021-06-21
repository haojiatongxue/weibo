<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container ">
    <a class="navbar-brand" href="{{route('home')}}">jack's page</a>
    <ul class="navbar-nav justify-content-end">
      @if (Auth::check())
        <li class="nav-item"><a class="nav-link" href="#">用户列表</a></li>
        <li class="nav-item dropdown" style="top: 8px">
          <a class="nav-item dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">个人中心</a>
            <a class="dropdown-item" href="#">编辑资料</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" href="#">
              <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <!-- 当用户退出时，实际上相当于删除了用户登录会话的资源，因此这里的退出操作需要使用 DELETE 请求来发送给服务器。由于浏览器不支持发送 DELETE 请求，因此我们需要使用一个隐藏域来伪造 DELETE 请求。 -->
                <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
              </form>
            </a>
          </div>
        </li>
      @else
      <li class="nav-item"><a class="nav-link" href="{{ route('help') }}">帮助</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
      @endif
    </ul>
  </div>
</nav>
