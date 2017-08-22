@extends('layouts.app')
@section('content')

    <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>分类列表</h5>
            </div>
            <div class="ibox-content">

                <p class="m-b-lg">
                    在这就办云平台的系统上，拥有者丰富的可读可选可编辑的分类列表，您可以根据您要的方式进行定制，我们的使命是提供更高效的后勤保障系统。
                </p>

                <div class="dd" id="nestable2">
                    <ol class="dd-list">
                        <li class="dd-item">
                            <div class="dd-handle">
                                <span class="label label-info"><i class="fa fa-users"></i></span> Cras ornare tristique.
                                <span class="span-icon-right">
                                    <i class="fa fa-edit"></i>
                                    <i class="fa fa-times span-i-icon-right"></i></span>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Nestable custom theme list</h5>
            </div>
            <div class="ibox-content">

                <p class="m-b-lg">
                    Each list you can customize by standard css styles. Each element is responsive so you can add to it
                    any other element to improve functionality of list.
                </p>

                <div class="dd" id="nestable2">
                    <ol class="dd-list">
                        <li class="dd-item" data-id="1">
                            <div class="dd-handle">
                                <span class="label label-info"><i class="fa fa-users"></i></span> Cras ornare tristique.
                            </div>

                        </li>
                        <li class="dd-item" data-id="5">
                            <div class="dd-handle">
                                <span class="label label-warning"><i class="fa fa-users"></i></span> Integer vitae
                                libero.
                            </div>

                        </li>
                        <li class="dd-item" data-id="4">
                            <div class="dd-handle">
                                <span class="pull-right"> 11:00 pm </span>
                                <span class="label label-info"><i class="fa fa-laptop"></i></span> Vestibulum commodo
                            </div>
                        </li>
                        <li class="dd-item" data-id="7">
                            <div class="dd-handle">
                                <span class="pull-right"> 16:00 pm </span>
                                <span class="label label-warning"><i class="fa fa-bomb"></i></span> Vivamus molestie
                                gravida turpis
                            </div>
                        </li>
                        <li class="dd-item" data-id="2">
                            <div class="dd-handle">
                                <span class="pull-right"> 12:00 pm </span>
                                <span class="label label-info"><i class="fa fa-cog"></i></span> Vivamus vestibulum nulla
                                nec ante.
                            </div>
                        </li>
                        <li class="dd-item" data-id="8">
                            <div class="dd-handle">
                                <span class="pull-right"> 21:00 pm </span>
                                <span class="label label-warning"><i class="fa fa-child"></i></span> Ut aliquam
                                sollicitudin leo.
                            </div>
                        </li>
                        <li class="dd-item" data-id="3">
                            <div class="dd-handle">
                                <span class="pull-right"> 11:00 pm </span>
                                <span class="label label-info"><i class="fa fa-bolt"></i></span> Nunc dignissim risus id
                                metus.
                            </div>
                        </li>
                        <li class="dd-item" data-id="6">
                            <div class="dd-handle">
                                <span class="pull-right"> 15:00 pm </span>
                                <span class="label label-warning"><i class="fa fa-users"></i></span> Nam convallis
                                pellentesque nisl.
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



@endsection