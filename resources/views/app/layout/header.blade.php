<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta name="description" content="">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="">
    <meta property="twitter:creator" content="">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Quiz">
    <meta property="og:title" content="Quiz">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:description" content="Quiz">
    <title>Quiz</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

    @yield('page-css')
    
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{url('app')}}">Quiz Eleitoral</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">

        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out fa-lg"></i>Sair
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>        
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('images/user.png') }}" width="80px;" alt="">
        <div>
          <p class="app-sidebar__user-name">Olá, 
            @if(Auth::user())
              {{Auth::user()->name}}
            @else 
              Usuario 
            @endif
          </p>
          <p class="app-sidebar__user-designation">
            @if(Auth::user())
              Bem-vindo
          @endif
          </p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item {{ (request()->is('app')) ? 'active' : '' }}" href="{{url('app')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview {{ (request()->is('app/campanhas/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/campanhas')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-braille"></i><span class="app-menu__label">Campanhas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/campanhas')) ? 'active' : '' }}" href="{{url('app/campanhas')}}"><i class="icon fa fa-circle-o"></i> Todas Campanhas</a></li>
            <li><a class="treeview-item {{ (request()->is('app/campanhas/create')) ? 'active' : '' }}" href="{{url('app/campanhas/create')}}"><i class="icon fa fa-circle-o"></i> Nova Campanha</a></li>
          </ul>
        </li>
  
        <li class="treeview {{ (request()->is('app/pessoas/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/pessoas')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Pessoas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/pessoas')) ? 'active' : '' }}" href="{{url('app/pessoas')}}"><i class="icon fa fa-circle-o"></i> Todos</a></li>
            <li><a class="treeview-item {{ (request()->is('app/pessoas/create')) ? 'active' : '' }}" href="{{url('app/pessoas/create')}}"><i class="icon fa fa-circle-o"></i> Cadastrar</a></li>
          </ul>
        </li>
        <!--
        <li class="treeview {{ (request()->is('app/bairros/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/bairros')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-map"></i><span class="app-menu__label">Bairros</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/bairros')) ? 'active' : '' }}" href="{{url('app/bairros')}}"><i class="icon fa fa-circle-o"></i> Todos</a></li>
            <li><a class="treeview-item {{ (request()->is('app/bairros/create')) ? 'active' : '' }}" href="{{url('app/bairros/create')}}"><i class="icon fa fa-circle-o"></i> Cadastrar</a></li>
          </ul>
        </li>  
      -->
        <li class="treeview {{ (request()->is('app/politicos/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/politicos')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-male"></i><span class="app-menu__label">Politicos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/politicos')) ? 'active' : '' }}" href="{{url('app/politicos')}}"><i class="icon fa fa-circle-o"></i> Todos</a></li>
            <li><a class="treeview-item {{ (request()->is('app/politicos/create')) ? 'active' : '' }}" href="{{url('app/politicos/create')}}"><i class="icon fa fa-circle-o"></i> Cadastrar</a></li>
          </ul>
        </li>   
        <li class="treeview {{ (request()->is('app/partido-politicos/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/partido-politicos')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-legal"></i><span class="app-menu__label">Partido Politico</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/partido-politicos')) ? 'active' : '' }}" href="{{url('app/partido-politicos')}}"><i class="icon fa fa-circle-o"></i> Todos</a></li>
            <li><a class="treeview-item {{ (request()->is('app/partido-politicos/create')) ? 'active' : '' }}" href="{{url('app/partido-politicos/create')}}"><i class="icon fa fa-circle-o"></i> Cadastrar</a></li>
          </ul>
        </li>  
      </ul>
    </aside>