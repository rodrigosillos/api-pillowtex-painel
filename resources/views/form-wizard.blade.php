@extends('layouts.master')
@section('title')
@lang('translation.Form_wizard')
@endsection
@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Forms @endslot
    @slot('title') Form wizard @endslot
@endcomponent
                        
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Basic pills Wizard</h4>

                    <div id="basic-pills-wizard" class="twitter-bs-wizard">
                        <ul class="twitter-bs-wizard-nav">
                            <li class="nav-item">
                                <a href="#seller-details" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">01</span>
                                    Seller Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#company-document" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">02</span>
                                    <span>Company Document</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="#bank-detail" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">03</span>
                                    Bank Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#confirm-detail" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">04</span>
                                    Confirm Detail
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content twitter-bs-wizard-tab-content">
                            <div class="tab-pane" id="seller-details">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-firstname-input">First name</label>
                                                <input type="text" class="form-control" id="basicpill-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-lastname-input">Last name</label>
                                                <input type="text" class="form-control" id="basicpill-lastname-input">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-phoneno-input">Phone</label>
                                                <input type="text" class="form-control" id="basicpill-phoneno-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-email-input">Email</label>
                                                <input type="email" class="form-control" id="basicpill-email-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="basicpill-address-input">Address</label>
                                                <textarea id="basicpill-address-input" class="form-control" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="company-document">
                                <div>
                                <form>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-pancard-input">PAN Card</label>
                                                <input type="text" class="form-control" id="basicpill-pancard-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-vatno-input">VAT/TIN No.</label>
                                                <input type="text" class="form-control" id="basicpill-vatno-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-cstno-input">CST No.</label>
                                                <input type="text" class="form-control" id="basicpill-cstno-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-servicetax-input">Service Tax No.</label>
                                                <input type="text" class="form-control" id="basicpill-servicetax-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-companyuin-input">Company UIN</label>
                                                <input type="text" class="form-control" id="basicpill-companyuin-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="basicpill-declaration-input">Declaration</label>
                                                <input type="text" class="form-control" id="basicpill-declaration-input">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="bank-detail">
                                <div>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="basicpill-namecard-input">Name on Card</label>
                                                    <input type="text" class="form-control" id="basicpill-namecard-input">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Credit Card Type</label>
                                                    <select class="custom-select">
                                                        <option selected>Select Card Type</option>
                                                        <option value="AE">American Express</option>
                                                        <option value="VI">Visa</option>
                                                        <option value="MC">MasterCard</option>
                                                        <option value="DI">Discover</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="basicpill-cardno-input">Credit Card Number</label>
                                                    <input type="text" class="form-control" id="basicpill-cardno-input">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="basicpill-card-verification-input">Card Verification Number</label>
                                                    <input type="text" class="form-control" id="basicpill-card-verification-input">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="basicpill-expiration-input">Expiration Date</label>
                                                    <input type="text" class="form-control" id="basicpill-expiration-input">
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                </div>
                            <div class="tab-pane" id="confirm-detail">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                            </div>
                                            <div>
                                                <h5>Confirm Detail</h5>
                                                <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <ul class="pager wizard twitter-bs-wizard-pager-link">
                            <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                            <li class="next"><a href="javascript: void(0);">Next</a></li>
                        </ul>
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
                    <h4 class="card-title mb-4">Wizard with progressbar</h4>

                    <div id="progrss-wizard" class="twitter-bs-wizard">
                        <ul class="twitter-bs-wizard-nav nav-justified">
                            <li class="nav-item">
                                <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">01</span>
                                    Seller Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">02</span>
                                    Company Document
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">03</span>
                                    Bank Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">04</span>
                                    Confirm Detail
                                </a>
                            </li>
                        </ul>

                        <div id="bar" class="progress mt-4">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                        </div>
                        <div class="tab-content twitter-bs-wizard-tab-content">
                            <div class="tab-pane" id="progress-seller-details">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-firstname-input">First name</label>
                                                <input type="text" class="form-control" id="progresspill-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-lastname-input">Last name</label>
                                                <input type="text" class="form-control" id="progresspill-lastname-input">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-phoneno-input">Phone</label>
                                                <input type="text" class="form-control" id="progresspill-phoneno-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-email-input">Email</label>
                                                <input type="email" class="form-control" id="progresspill-email-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="progresspill-address-input">Address</label>
                                                <textarea id="progresspill-address-input" class="form-control" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="progress-company-document">
                                <div>
                                <form>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-pancard-input">PAN Card</label>
                                                <input type="text" class="form-control" id="progresspill-pancard-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-vatno-input">VAT/TIN No.</label>
                                                <input type="text" class="form-control" id="progresspill-vatno-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-cstno-input">CST No.</label>
                                                <input type="text" class="form-control" id="progresspill-cstno-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-servicetax-input">Service Tax No.</label>
                                                <input type="text" class="form-control" id="progresspill-servicetax-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-companyuin-input">Company UIN</label>
                                                <input type="text" class="form-control" id="progresspill-companyuin-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="progresspill-declaration-input">Declaration</label>
                                                <input type="text" class="form-control" id="progresspill-declaration-input">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="progress-bank-detail">
                                <div>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="progresspill-namecard-input">Name on Card</label>
                                                    <input type="text" class="form-control" id="progresspill-namecard-input">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Credit Card Type</label>
                                                    <select class="custom-select">
                                                        <option selected>Select Card Type</option>
                                                        <option value="AE">American Express</option>
                                                        <option value="VI">Visa</option>
                                                        <option value="MC">MasterCard</option>
                                                        <option value="DI">Discover</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="progresspill-cardno-input">Credit Card Number</label>
                                                    <input type="text" class="form-control" id="progresspill-cardno-input">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="progresspill-card-verification-input">Card Verification Number</label>
                                                    <input type="text" class="form-control" id="progresspill-card-verification-input">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="progresspill-expiration-input">Expiration Date</label>
                                                    <input type="text" class="form-control" id="progresspill-expiration-input">
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="progress-confirm-detail">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                            </div>
                                            <div>
                                                <h5>Confirm Detail</h5>
                                                <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pager wizard twitter-bs-wizard-pager-link">
                            <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                            <li class="next"><a href="javascript: void(0);">Next</a></li>
                        </ul>
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
                    <h4 class="card-title mb-4">Vertical nav Wizard</h4>

                    <div id="vertical-nav-wizard" class="twitter-bs-wizard verti-nav-wizard">
                        <div class="row">
                            <div class="col-xl-3 col-sm-4">
                                <ul class="twitter-bs-wizard-nav">
                                    <li class="nav-item">
                                        <a href="#verti-nav-seller-details" class="nav-link" data-toggle="tab">
                                            <span class="step-number mr-2">01</span>
                                            Seller Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#verti-nav-company-document" class="nav-link" data-toggle="tab">
                                            <span class="step-number mr-2">02</span>
                                            <span>Company Document</span>
                                        </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a href="#verti-nav-bank-detail" class="nav-link" data-toggle="tab">
                                            <span class="step-number mr-2">03</span>
                                            Bank Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#verti-nav-confirm-detail" class="nav-link" data-toggle="tab">
                                            <span class="step-number mr-2">04</span>
                                            Confirm Detail
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-xl-9 col-sm-8">
                                <div class="tab-content twitter-bs-wizard-tab-content px-sm-3 pt-sm-0">
                                    <div class="tab-pane" id="verti-nav-seller-details">
                                        <form>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-firstname-input">First name</label>
                                                        <input type="text" class="form-control" id="verti-nav-firstname-input">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-lastname-input">Last name</label>
                                                        <input type="text" class="form-control" id="verti-nav-lastname-input">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-phoneno-input">Phone</label>
                                                        <input type="text" class="form-control" id="verti-nav-phoneno-input">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-email-input">Email</label>
                                                        <input type="email" class="form-control" id="verti-nav-email-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="verti-nav-address-input">Address</label>
                                                        <textarea id="verti-nav-address-input" class="form-control" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="verti-nav-company-document">
                                        <div>
                                        <form>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-pancard-input">PAN Card</label>
                                                        <input type="text" class="form-control" id="verti-nav-pancard-input">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-vatno-input">VAT/TIN No.</label>
                                                        <input type="text" class="form-control" id="verti-nav-vatno-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-cstno-input">CST No.</label>
                                                        <input type="text" class="form-control" id="verti-nav-cstno-input">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-servicetax-input">Service Tax No.</label>
                                                        <input type="text" class="form-control" id="verti-nav-servicetax-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-companyuin-input">Company UIN</label>
                                                        <input type="text" class="form-control" id="verti-nav-companyuin-input">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="verti-nav-declaration-input">Declaration</label>
                                                        <input type="text" class="form-control" id="verti-nav-declaration-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="verti-nav-bank-detail">
                                        <div>
                                            <form>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="verti-nav-namecard-input">Name on Card</label>
                                                            <input type="text" class="form-control" id="verti-nav-namecard-input">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Credit Card Type</label>
                                                            <select class="custom-select">
                                                                <option selected>Select Card Type</option>
                                                                <option value="AE">American Express</option>
                                                                <option value="VI">Visa</option>
                                                                <option value="MC">MasterCard</option>
                                                                <option value="DI">Discover</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="verti-nav-cardno-input">Credit Card Number</label>
                                                            <input type="text" class="form-control" id="verti-nav-cardno-input">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="verti-nav-card-verification-input">Card Verification Number</label>
                                                            <input type="text" class="form-control" id="verti-nav-card-verification-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="verti-nav-expiration-input">Expiration Date</label>
                                                            <input type="text" class="form-control" id="verti-nav-expiration-input">
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    <div class="tab-pane" id="verti-nav-confirm-detail">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-6">
                                                <div class="text-center">
                                                    <div class="mb-4">
                                                        <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                    </div>
                                                    <div>
                                                        <h5>Confirm Detail</h5>
                                                        <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <ul class="pager wizard twitter-bs-wizard-pager-link  px-sm-3">
                                    <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                    <li class="next"><a href="javascript: void(0);">Next</a></li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')
     <!-- twitter-bootstrap-wizard js -->
    <script src="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js')}}"></script>
@endsection
