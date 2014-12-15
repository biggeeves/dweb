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
                <a class="navbar-brand" href="/">Generic Database</a>
            </div>
            <div class="collapse navbar-collapse bs-example-js-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Database Tables<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                            @foreach ($tables as $tablename)
                                @foreach($tablename as $key=>$value)
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="generic?crf={{$value}}">{{$value}}</a></li>
                                @endforeach
                            @endforeach			  
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Table Schema<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                            @foreach ($tables as $tablename)
                                @foreach($tablename as $key=>$value)
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/dcc/public/crf_schema/{{$value}}">{{$value}}</a></li>
                                @endforeach
                            @endforeach			  
                        </ul>
                    </li>
                </ul>

<ul class="nav navbar-nav navbar-right">
                    <li id="fat-menu" class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">Schemas <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
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