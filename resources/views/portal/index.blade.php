@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content wrapper-content2 animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>自定义样式</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <img src="{{ asset('assets/img/profile.jpg') }}" class="img-circle img-md">
                    <button class="btn blue img-circle img-md">
                        这就办
                    </button>
                    <div class="bg-blue font-white img-circle img-md btn-circle-md">
                        这就办
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Paragraph text</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Headings</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1>Heading 1
                        <small>Sub-heading</small>
                    </h1>
                    <h2>Heading 2
                        <small>Sub-heading</small>
                    </h2>
                    <h3>Heading 3
                        <small>Sub-heading</small>
                    </h3>
                    <h4>Heading 4
                        <small>Sub-heading</small>
                    </h4>
                    <h5>Heading 5
                        <small>Sub-heading</small>
                    </h5>
                    <h6>Heading 6
                        <small>Sub-heading</small>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Paragraph text</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <p>Lorem ipsum <strong>eget urna mollis</strong> ornare vel eu leo. <em>Cum sociisnatoque penatibus</em> et magnis dis parturient montes, <code>code</code> nascetur
                        ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit. Sed euismod aliquet sapien consequat tincidunt.</p>

                    <p>Vivamus sagittis lacus vel augue laoreet <abbr title="" data-original-title="Sample abbreviation">rutrum faucibus dolor auctor</abbr>. Duis mollis, est non commodo
                        luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui. Sed euismod aliquet sapien consequat tincidunt.</p>

                    <p>
                        But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Headings</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1>Heading 1
                        <small>Sub-heading</small>
                    </h1>
                    <h2>Heading 2
                        <small>Sub-heading</small>
                    </h2>
                    <h3>Heading 3
                        <small>Sub-heading</small>
                    </h3>
                    <h4>Heading 4
                        <small>Sub-heading</small>
                    </h4>
                    <h5>Heading 5
                        <small>Sub-heading</small>
                    </h5>
                    <h6>Heading 6
                        <small>Sub-heading</small>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Paragraph text</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <p>Lorem ipsum <strong>eget urna mollis</strong> ornare vel eu leo. <em>Cum sociisnatoque penatibus</em> et magnis dis parturient montes, <code>code</code> nascetur
                        ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit. Sed euismod aliquet sapien consequat tincidunt.</p>

                    <p>Vivamus sagittis lacus vel augue laoreet <abbr title="" data-original-title="Sample abbreviation">rutrum faucibus dolor auctor</abbr>. Duis mollis, est non commodo
                        luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui. Sed euismod aliquet sapien consequat tincidunt.</p>

                    <p>
                        But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection