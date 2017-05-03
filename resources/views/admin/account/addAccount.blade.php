@extends('admin.layouts.default')

@section('head_css')
@endsection

@section('content')
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="/">首页</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="#">成员管理</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-9">
                <h3 class="page-title">
                    成员管理 &nbsp;<small>维护组织内成员信息，手机号将作为云助理登录帐号使用。</small>
                </h3>
            </div>
            <div class="col-md-3" style="text-align: right">
                <div class="actions"  style="margin:20px 0">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" >
                <div class="portlet light bordered">
                    <!-- Begin: life time stats -->
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="AddForm" method="post" role="form" class="form-horizontal">
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">姓名<span class="required" >*</span></label>
                                            <div class="col-md-10">
                                                <input type="text" id="account_real_name" name="account_real_name" value="" placeholder="输入姓名" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">密码<span class="required" >*</span></label>
                                            <div class="col-md-10">
                                                <input type="password" id="password" name="password" value="" placeholder="输入密码" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">性别<span class="required" >*</span></label>
                                            <div  class="col-md-10" >
                                                <div class="radio-list ">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="account_sex" id="account_sex_1" value="1" checked="checked" />男
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="account_sex" id="account_sex_2" value="2" />女
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">手机号码<span class="required" >*</span></label>
                                            <div class="col-md-10">
                                                <input type="text" id="account_tel" name="account_tel" value="" placeholder="输入11位有效手机号码" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">状态<span class="required" >*</span></label>
                                            <div class="col-md-10">
                                                <select class="form-control" id="account_status" name="account_status">
                                                    <option value="1" selected="selected">活动</option>
                                                    <option value="0">锁定</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-10">
                                                <button type="button" class="btn blue" onclick="Function_SaveForm();">保存</button>
                                                <button type="button" onclick="location.href='/admin/account'" class="btn" class="btn btn-default">返回</button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot_script')
    <script type="text/javascript">

        $(function(){

            App.initUniform();

            jQuery.validator.addMethod("checkPhone", function(value, element) {
                return this.optional(element) || ( /^1[34578]\d{9}$/.test(value));
            }, "请输入正确的手机号码");

            var setting = {
                rules: {
                    account_real_name: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    account_sex: {
                        required: true
                    },
                    account_tel: {
                        required: true,
                        checkPhone:true,
                    }
                },
            }

            WX.Validate('AddForm',setting);

            var options = {
                dataType:  'json',
                beforeSubmit:  function() {
                    App.blockUI({ animate: true});
                    return true;
                },
                success: function(responseText){
                    App.unblockUI();
                    if(responseText){
                        if(responseText.code == 1) {
                            WX.toastr({'type':'success','message':'新增成功！', 'onHidden':function(){
                                location.href = "/admin/account";
                            }});
                        }else{
                            WX.toastr({'type':'error','message': '新增失败'});
                        }
                    }
                }
            };
            $('#AddForm').ajaxForm(options);

        })

        function Function_SaveForm(){
            $("#AddForm").attr('action','/admin/account/save');
            $("#AddForm").submit();
        }

    </script>
@endsection
