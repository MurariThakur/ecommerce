<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                    role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                                    aria-controls="register" aria-selected="false">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">
                            <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                aria-labelledby="signin-tab">
                                <form id="login-form">
                                    <div id="login-errors" class="alert alert-danger mb-1" style="display: none;"></div>

                                    <div class="form-group">
                                        <label for="singin-email">Email Address *</label>
                                        <input type="email" class="form-control" id="singin-email" name="email"
                                            required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="singin-password">Password *</label>
                                        <input type="password" class="form-control" id="singin-password" name="password"
                                            required>
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2" id="login-btn">
                                            <span>LOG IN</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        

                                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Your
                                            Password?</a>
                                    </div><!-- End .form-footer -->
                                </form>
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form id="register-form">
                                    <div id="register-errors" class="alert alert-danger mb-1" style="display: none;">
                                    </div>
                                    <div id="register-success" class="alert alert-success mb-1" style="display: none;">
                                    </div>

                                    <div class="form-group">
                                        <label for="register-name">Full Name *</label>
                                        <input type="text" class="form-control" id="register-name" name="name"
                                            required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="register-email">Email Address *</label>
                                        <input type="email" class="form-control" id="register-email" name="email"
                                            required>
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="register-password">Password *</label>
                                        <input type="password" class="form-control" id="register-password"
                                            name="password" required>
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2" id="register-btn">
                                            <span>SIGN UP</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="register-policy"
                                                name="policy" required>
                                            <label class="custom-control-label" for="register-policy">I agree to
                                                the privacy policy *</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .form-footer -->
                                </form>
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .form-tab -->
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div><!-- End .modal -->

<!-- Success Modal -->
<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="icon-check-circle" style="font-size: 3rem; color: #28a745;"></i>
                </div>
                <h4 class="mb-3">Registration Successful!</h4>
                <p id="success-message" class="mb-4"></p>
                <button type="button" class="btn btn-primary" id="success-ok-btn">OK</button>
            </div>
        </div>
    </div>
</div>
