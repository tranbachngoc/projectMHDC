<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$this->load->view('home/common/header');
?>
<style>
    .btn-box {
        float: right;
    }

    .lkv_registry label {
        width: 108px;
        display: inline-block;
    }
    #main .lkv_registry ul > li {
        list-style: none;
        padding: 5px 0;
    }

    .lkv_registry ul > li input {
        width:300px;
        float: none;
        display: inline;
    }

    .lkv_registry .error {
        color: red;
    }

    #main .lkv_registry button {
        padding: 5px;
        cursor: pointer;
    }
</style>
<div class = "container">
    <div class = "row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
    <div class = "col-lg-9 col-md-9 col-sm-8 col-xs-12 cpanel">
            <div id="panel_direct" class="panel panel-default">
                <div class="panel-heading text-center"><h4>Azi-direct: Phần mềm chăm sóc khách hàng trực tuyến</h4></div>
            <div class="panel-body">
                <div id = "main">
                    <ul class = "nav nav-tabs">
                        <li class = "active"><a href = "#tab2success" data-toggle = "tab">Phần mềm</a></li>
                        <li><a href = "#tab1success" data-toggle = "tab">Thông tin chi tiết</a></li>
                    </ul>
                    <div class = "tab-content">
                        <div class = "tab-pane fade  in active" id = "tab2success">
                            <?php if ($shop->sho_company_code == "") { ?>
                                <div id = "system-message-container">
                                </div>
                                <div ng-app = "lkvchat" class = "ng-scope">
                                    <ng-view>
                                        <div ng-controller = "Home" class = "ng-scope">
                                            <form name = "form" ng-submit = "Registry(form,visitor)"
                                                  class = "ng-invalid ng-invalid-required ng-valid-maxlength ng-valid-pattern ng-valid-email ng-dirty ng-valid-parse form-horizontal">
                                                <div class = "lkv_registry">
                                                    <p class="form-group col-sm-12">
                                                        Bạn vui lòng đăng ký tài khoản để tải phần mềm về và cài đặt
                                                    </p>
                                                    <ul>
                                                        <li class="form-group">
                                                            <label> Công ty:</label> <input id = "lkv_name" name = "lkv_name"
                                                                                            type = "text"
                                                                                            class = "lkv_input ng-pristine ng-untouched form-control"
                                                                                            ng-model = "visitor.name"
                                                                                            placeholder = "Tên công ty (*)"
                                                                                            disabled>
                                                        </li>
                                                        <li class="form-group">Company Code là mã dùng để cài đặt phần mềm. Sau khi đăng ký thành công
                                                            bạn lưu cẩn thận mã này. Khi cài đặt phần mềm LKV chat, nhớ nhập lại
                                                            đúng mã này.
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Company Code: </label> <input id = "lkv_company"
                                                                                                  name = "lkv_company" type = "text"
                                                                                                  class = "lkv_input  ng-dirty  ng-touched  form-control"
                                                                                                  ng-model = "visitor.company"
                                                                                                  placeholder = "Không dấu và khoảng trắng (*)"
                                                                                                  disabled> <span
                                                                class = "error ng-binding"></span>
                      <span class = "error ng-hide" ng-show = "form.lkv_company.$error.pattern">
                        Không dấu và khoảng trắng
                      </span>
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Tên đăng nhập: </label> <input maxlength = "15"
                                                                                                   id = "lkv_username"
                                                                                                   name = "lkv_username"
                                                                                                   type = "text"
                                                                                                   class = "lkv_input  ng-touched ng-dirty form-control"
                                                                                                   ng-model = "visitor.username"
                                                                                                   placeholder = "Không dấu và khoảng trắng (*)"
                                                                                                   disabled>
                        <span class = "error ng-hide" ng-show = "form.lkv_username.$error.pattern">
                          Không dấu và khoảng trắng
                        </span>
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Password: </label> <input required = "" id = "lkv_pass"
                                                                                              name = "lkv_pass" type = "password"
                                                                                              class = "lkv_input ng-pristine ng-untouched ng-invalid ng-invalid-required"
                                                                                              ng-model = "visitor.pass">
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Re-Password: </label> <input required = "" id = "lkv_repass"
                                                                                                 name = "lkv_repass"
                                                                                                 type = "password"
                                                                                                 class = "lkv_input ng-pristine ng-invalid ng-invalid-required ng-touched"
                                                                                                 ng-model = "visitor.repass"> <span
                                                                class = "error ng-binding"></span>
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Email: </label> <input type = "email" id = "lkv_email"
                                                                                           name = "lkv_email"
                                                                                           class = "lkv_input ng-pristine ng-untouched form-control"
                                                                                           ng-model = "visitor.email"
                                                                                           placeholder = "Email (*)" disabled>
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Địa chỉ: </label> <input type = "text" id = "lkv_address"
                                                                                             name = "lkv_address"
                                                                                             class = "lkv_input ng-pristine ng-untouched form-control"
                                                                                             ng-model = "visitor.address"
                                                                                             placeholder = "Địa chỉ (*)" disabled>
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Website: </label> <input type = "text" id = "lkv_web"
                                                                                             name = "lkv_web"
                                                                                             class = "lkv_input ng-pristine ng-untouched form-control"
                                                                                             ng-model = "visitor.web"
                                                                                             placeholder = "web (*)" disabled>
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Điện thoại: </label> <input id = "lkv_phone" name = "lkv_phone"
                                                                                                type = "text"
                                                                                                class = "lkv_input ng-pristine ng-untouched form-control"
                                                                                                ng-model = "visitor.tel"
                                                                                                placeholder = "Điện thoại" disabled>
                                                        </li>
                                                        <li class="form-group">
                                                            <label> Gói:</label> <select style="padding: 5px; width: 300px ">
                                                                <option value = "1">Cá nhân</option>
                                                            </select>
                                                        </li>
                                                        <li class = "ng-binding form-group">
                                                            <button ng-disabled = "submit_disable" class = "lkv_button btn btn-primary"
                                                                    type = "submit" id = "lkv_send" title = "Message">Đăng ký
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>
                                    </ng-view>
                                </div>
                            <?php } else { ?>

                                <div class = "registration-complete">
                                    <div class = "bs-callout bs-callout-info" id = "callout-progress-animation-css3">
                                        <h4>Chúc mừng bạn tạo thành công tài khoản  Azi-direct: Chăm sóc khách hàng trực tuyến</h4>
                                        <p>
                                            Việc liên hệ với khách hàng thông qua website của bạn không thể tiện lợi và đơn giản hơn nữa.
                                            Bạn chỉ cần cài đặt phần mềm  Azi-direct tại máy tính, điện thoại.
                                            Bất cứ khí nào bạn đều có thể liên lạc, tư vấn cho khách hàng của bạn thông qua website.
                                            Khách hàng chỉ cần truy cập website của bạn, không cần cài đặt bất cứ gì.
                                            Azi-direct tạo sự tiện lợi nhất cho  khách hàng của bạn.
                                        </p>
                                        <p>
                                            Bây giờ bạn hãy click vào <a target="_blank" class="btn btn-default1" href = "http://www.livechatsoftware.com.vn/setup.zip" title = "live chat Download"><strong>Download</strong></a>
                                             để tải về phần mềm và cài đặt.
                                        </p>
                                        <p>
                                            Sau khi cài đặt phần mềm thành công thì bạn hãy đăng nhập vào phần mềm bằng phần mềm bạn đã đăng ký  <b> <?php echo $shop->sho_company_code; ?> </b>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                        <div class = "tab-pane fade" id = "tab1success">
                            <div class = "bs-docs-section">
                                <div class = "bs-callout bs-callout-info" id = "callout-progress-animation-css3">
                                    <h4>Giới thiệu về công cụ marketing Azi-direct: Chăm sóc khách hàng trực tuyến</h4>
                                    <p>
                                        Việc liên hệ với khách hàng thông qua website của bạn không thể tiện lợi và đơn giản hơn nữa.
                                        Bạn chỉ cần cài đặt phần mềm Azi-direct tại máy tính, điện thoại.
                                        Bất cứ khí nào bạn đều có thể liên lạc, tư vấn cho khách hàng của bạn thông qua website.
                                        Khách hàng chỉ cần truy cập website của bạn, không cần cài đặt bất cứ gì.
                                        Azi-direct tạo sự tiện lợi nhất cho  khách hàng của bạn.
                                    </p>
                                </div>
                                <div class = "bs-callout bs-callout-danger">
                                    <h4 id = "callout-progress-csp"> Công dụng, tính năng</h4>
                                    <p>Sử dụng công nghệ điện toán đám mây hiện đại nhất, giúp kết nối  Azi-direct với website theo thời gian thực giúp việc hỗ trợ khách hàng trở nên dẽ dàng và tạo sự tin tưởng cao của khách hàng đối với website.
                                        Bạn cần công cụ để theo dõi lượng truy cập website, bạn cũng cần Azi-direct - Phần mềm hỗ trợ khách hàng. Với Azi-direct bạn có hai trong một.
                                    </p>
                                </div>
                                <div class = "bs-callout bs-callout-warning" id = "callout-progress-animation-css3">
                                    <h4>Hướng dẫn sử dụng</h4>
                                    <p>
                                      Bạn hãy click vào tab <strong>Tạo tài khoản</strong> để đăng ký và tải về bản cài đặt của phần mềm
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
        <!--END RIGHT-->
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
<?php if ($shop->sho_company_code == "") { ?>
    <script src = "<?php echo base_url() ?>templates/home/js/angularjs.js" type = "text/javascript"
            language = "javascript"></script>
    <script type = "text/javascript" lang = "javascript">
        angular.module("lkvchat", ["lkvchat.controllers", "lkvchat.services"]), angular.module("lkvchat.controllers", []).controller("Home", ["$scope", "$rootScope", "socketio", "$window", function (e, t, n, o) {
            e.visitor = {};
            e.visitor.name = '<?php echo $shop->sho_name; ?>';
            e.visitor.company = '<?php echo "az_" . $user->use_username; ?>';
            e.visitor.username = '<?php echo "az_" . $user->use_username; ?>';
            e.visitor.email = '<?php echo $user->use_email; ?>';
            e.visitor.address = '<?php echo $shop->sho_address; ?>';
            e.visitor.web = '<?php echo base_url() . $shop->sho_link; ?>';
            e.visitor.tel = '<?php echo $shop->sho_phone; ?>';
            e.repass_err = e.companycode_err = "", e.Registry = function (t, a) {
                if (t.$valid) {
                    e.companycode_err = "", e.status = "", e.submit_disable = !1;
                    var r = {
                                Id: a.company,
                                Name: a.name,
                                Address: a.address,
                                RegistryDate: new Date,
                                ExpireDate: new Date((new Date).getTime() + 31536e6),
                                NumberSeat: 1,
                                InviteText: "Xin chào quý khách!",
                                Package: 1,
                                InviteWait: 3,
                                InviteExpire: 1,
                                InviteEnable: !0,
                                web: a.web
                            },
                            c = {
                                Fullname: a.name,
                                company: a.company,
                                username: a.username,
                                email: a.email,
                                tel: a.tel,
                                password: CryptoJS.MD5(a.pass).toString(CryptoJS.enc.Hex),
                                role: 1
                            };

                    if (a.pass != a.repass) return void(e.repass_err = "re-password sai");
                    e.repass_err = "", e.status = "Connecting to server ...",
                            e.submit_disable = !0, n.emit("user_registry", {
                        company: r,
                        account: c
                    }, function (t) {
                        console.log(t);
                        if (t) {
                            update_companycode(a.username);
                        } else {
                            alert("có lỗi xảy ra, vui lòng thử lại sau")
                        }
                    })
                }
            }
        }]), angular.module("lkvchat.services", []).factory("socketio", ["$rootScope", function (e) {
            var t = io.connect("s3.livechatsoftware.com.vn:1653/lkvsolutions", {
                "reconnection delay": 100,
                "max reconnection attempts": 100
            });
            return t.on("connect", function () {
            }), {
                getUser: function (t) {
                    var n = e.onlines.filter(function (e) {
                        return e._id == t
                    });
                    return n.length > 0 ? n[0] : void 0
                },
                on: function (n, o) {
                    t.on(n, function () {
                        var n = arguments;
                        e.$apply(function () {
                            o.apply(t, n)
                        })
                    })
                },
                emit: function (n, o, a) {
                    t.emit(n, o, function () {
                        var n = arguments;
                        e.$apply(function () {
                            a && a.apply(t, n)
                        })
                    })
                }
            }
        }]);
        function update_companycode(company_code) {
            $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?php echo base_url(); ?>account/update_company_code/",
                        data: {company_code: company_code}
                    })
                    .done(function (msg) {
                        if (msg.isOk) {
                            $("#btn-addnew").trigger("click");
                        }

                    });
        }
    </script>
    <a href = "#" class = "btn btn-success" data-toggle = "modal" data-target = "#addNew" data-backdrop = "static"
       data-keyboard = "false" id = "btn-addnew" style = "display:none;"></a>
    <div class = "modal fade" id = "addNew" tabindex = "-1" role = "dialog" aria-labelledby = "addNewLabel">
        <div class = "modal-dialog modal-lg" role = "document">
            <div class = "modal-content">
                <div class = "modal-body">
                    <div class = "btn-box">
                        <a href = "#" class = "btn btn-danger" onclick="location.reload();" data-dismiss = "modal">Đóng</a>
                    </div>
                    <div class = "registration-complete">
                        <p>
                            Bây giờ bạn có thể download phần mềm và cài đặt.
                        </p>
                        <a target="_blank" href = "http://www.livechatsoftware.com.vn/setup.zip" title = "live chat Download"
                           style = "text-decoration: none; text-transform: uppercase; background: #E0941D; margin: 10px 10px 0px 10px; display: block; line-height: 30px; border-radius: 4px; box-shadow: 1px 1px 2px #aaa; color: #fff; width: 110px; border: solid 1px #E0941D; text-align: center;"><strong>Download</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
