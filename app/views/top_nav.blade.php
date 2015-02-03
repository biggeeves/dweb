<div class="bs-example">
    <nav id="navbar-example" class="navbar navbar-default navbar-static" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-example-js-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{URL::to('/')}}">@if(isset($DBNAME)){{$DBName }}@else Welcome @endif</a>
            </div>
            <div class="collapse navbar-collapse bs-example-js-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Database Tables<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                            @if (isset($tables)) 
                                @foreach ($tables as $tablename)
                                    @foreach($tablename as $key=>$value)
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('showForm', array('value'=>$value))}}">{{$value}}</a></li>
                                    @endforeach
                                @endforeach			  
                            @else
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">No Tables passed in</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Table Schema<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                            @if (isset($tables))
                                @foreach ($tables as $tablename)
                                    @foreach($tablename as $key=>$value)
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('crfSchema', array('value'=>$value))}}">{{$value}}</a></li>
                                    @endforeach
                                @endforeach			  
                            @else
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">No Tables passed in</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('/liststats')}}">List Stats</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">No Reports Yet</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li id="fat-menu" class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                        @if (Auth::check())
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('/logout')}}">Log Out</a></li>
                        @else
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('/login')}}">Log in</a></li>
                        @endif
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="http://twitter.com/fat">Action</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="http://twitter.com/fat">Another action</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="http://twitter.com/fat">Something else here</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="http://twitter.com/fat">Separated link</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.nav-collapse -->
        </div><!-- /.container-fluid -->
    </nav> <!-- /navbar-example -->
</div> <!-- /example -->