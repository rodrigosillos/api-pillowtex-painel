@extends('layouts.master')
@section('title')
Basic Elements
@endsection
@section('body')
<body>
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Forms @endslot
    @slot('title') Basic Elements @endslot
@endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Textual inputs</h4>
                    <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                        textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Text</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-md-2 col-form-label">Search</label>
                        <div class="col-md-10">
                            <input class="form-control" type="search" value="How do I shoot web" id="example-search-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input class="form-control" type="email" value="bootstrap@example.com" id="example-email-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-url-input" class="col-md-2 col-form-label">URL</label>
                        <div class="col-md-10">
                            <input class="form-control" type="url" value="https://getbootstrap.com" id="example-url-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-md-2 col-form-label">Telephone</label>
                        <div class="col-md-10">
                            <input class="form-control" type="tel" value="1-(555)-555-5555" id="example-tel-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" value="hunter2" id="example-password-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Number</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" value="42" id="example-number-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-datetime-local-input" class="col-md-2 col-form-label">Date and time</label>
                        <div class="col-md-10">
                            <input class="form-control" type="datetime-local" value="2019-08-19T13:45:00" id="example-datetime-local-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-date-input" class="col-md-2 col-form-label">Date</label>
                        <div class="col-md-10">
                            <input class="form-control" type="date" value="2019-08-19" id="example-date-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-month-input" class="col-md-2 col-form-label">Month</label>
                        <div class="col-md-10">
                            <input class="form-control" type="month" value="2019-08" id="example-month-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-week-input" class="col-md-2 col-form-label">Week</label>
                        <div class="col-md-10">
                            <input class="form-control" type="week" value="2019-W33" id="example-week-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-time-input" class="col-md-2 col-form-label">Time</label>
                        <div class="col-md-10">
                            <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-color-input" class="col-md-2 col-form-label">Color</label>
                        <div class="col-md-10">
                            <input class="form-control" type="color" value="#5b8ce8" id="example-color-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Select</label>
                        <div class="col-md-10">
                            <select class="form-control">
                                <option>Select</option>
                                <option>Large select</option>
                                <option>Small select</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Custom Select</label>
                        <div class="col-md-10">
                            <select class="custom-select">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="formControlRange" class="col-md-2 col-form-label">Range Inputs</label>
                        <div class="col-md-10 align-self-center">
                            <input type="range" class="form-control-range" id="formControlRange">
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form layouts</h4>

                    <div class="row">
                        <div class="col-lg-5">
                            <div class="mt-4">
                                <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary mr-1"></i> Form groups</h5>
                                <form>
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">First name</label>
                                        <input type="text" class="form-control" id="formrow-firstname-input">
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formrow-email-input">Email</label>
                                                <input type="email" class="form-control" id="formrow-email-input">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formrow-password-input">Password</label>
                                                <input type="password" class="form-control" id="formrow-password-input">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="formrow-customCheck">
                                            <label class="custom-control-label" for="formrow-customCheck">Check me out</label>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 ml-lg-auto">
                            <div class="mt-5 mt-lg-4">
                                <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary mr-1"></i> Horizontal form</h5>
                                
                                <form>
                                    <div class="form-group row mb-4">
                                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">First name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="horizontal-firstname-input">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="horizontal-email-input">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="horizontal-password-input">
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-end">
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox mb-4">
                                                <input type="checkbox" class="custom-control-input" id="horizontal-customCheck">
                                                <label class="custom-control-label" for="horizontal-customCheck">Remember me</label>
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary mr-1"></i> Inline forms layout</h5>

                        <form class="form-inline">
                            <label class="sr-only" for="inlineFormInputName2">Name</label>
                            <input type="text" class="form-control mb-2 mr-sm-3" id="inlineFormInputName2" placeholder="Enter Name">
                            
                            <label class="sr-only" for="inlineFormemail2">Email</label>
                            <div class="input-group mb-2 mr-sm-3">
                                <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                                </div>
                                <input type="email" class="form-control" id="inlineFormemail2" placeholder="Enter Email">
                            </div>
                            

                            <div class="custom-control custom-checkbox mb-2 mr-sm-3">
                                <input type="checkbox" class="custom-control-input" id="inlineForm-customCheck">
                                <label class="custom-control-label" for="inlineForm-customCheck">Remember me</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary mb-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form Layout -->

    <!-- Start Form Sizing -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-5">
                <div class="card-body">
                    <h4 class="card-title">Sizing</h4>
                    <p class="card-title-desc">Set heights using classes like <code>.form-control-lg</code> and <code>.form-control-sm</code>.</p>

                    <form>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="default-input">Default input</label>
                                    <input class="form-control" type="text" id="default-input" placeholder="Default input">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mt-3">
                                    <label for="form-sm-input">Form Small input</label>
                                    <input class="form-control form-control-sm" type="text" id="form-sm-input" placeholder=".form-control-sm">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group mt-3 mb-0">
                                    <label for="form-lg-input">Form Large input</label>
                                    <input class="form-control form-control-lg" type="text" id="form-lg-input" placeholder=".form-control-lg">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form Sizing -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Checkboxes</h4>

                    <div class="row">
                        <div class="col-md-5">
                            <div>
                                <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary mr-1"></i>Default Checkboxes</h5>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Default checkbox
                                    </label>
                                </div>
                                <div class="form-check form-check-right">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" checked>
                                    <label class="form-check-label" for="defaultCheck2">
                                        Default checkbox Right
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ml-auto">
                            <div class="mt-4 mt-md-0">
                                <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary mr-1"></i>Custom Checkboxes</h5>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" checked>
                                    <label class="custom-control-label" for="customCheck1">Custom checkbox</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-right">
                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                    <label class="custom-control-label" for="customCheck2">Custom checkbox Right</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Radios</h4>

                    <div class="row">
                        <div class="col-md-5">
                            <div>
                                <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary mr-1"></i>Default Radios</h5>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Default radio
                                    </label>
                                </div>
                                <div class="form-check form-check-right">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Default radio Right
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ml-auto">
                            <div class="mt-4 mt-lg-0">
                                <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary mr-1"></i>Custom Radios</h5>
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1">Toggle this custom radio</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-right">
                                    <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="customRadio2">Or toggle this Right custom radio</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Switches</h4>
                    <p class="card-title-desc">A switch has the markup of a custom checkbox but uses the <code>.custom-switch</code> class to render a toggle switch. Switches also support the <code>disabled</code> attribute.</p>

                    <div class="row">

                        <div class="col-md-6">
                            <div>
                                <h5 class="font-size-14 mb-3">Switch examples</h5>
                                <div class="custom-control custom-switch mb-3" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                                    <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>
                                </div>
                                <div class="custom-control custom-switch" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" disabled id="customSwitch2">
                                    <label class="custom-control-label" for="customSwitch2">Disabled switch element</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4 mt-md-0">
                                <h5 class="font-size-14 mb-3">Switch sizes</h5>

                                <div class="custom-control custom-switch mb-3" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="customSwitchsizesm" checked>
                                    <label class="custom-control-label" for="customSwitchsizesm">Small Size Switch</label>
                                </div>

                                <div class="custom-control custom-switch custom-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="customSwitchsizemd">
                                    <label class="custom-control-label" for="customSwitchsizemd">Medium Size Switch</label>
                                </div>

                                <div class="custom-control custom-switch custom-switch-lg mb-3" dir="ltr">
                                    <input type="checkbox" class="custom-control-input" id="customSwitchsizelg" checked>
                                    <label class="custom-control-label" for="customSwitchsizelg">Large Size Switch</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    
@endsection