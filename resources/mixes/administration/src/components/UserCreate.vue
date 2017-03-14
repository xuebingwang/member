<script>
  export default {
    data () {
      return {
        user: {
          birthday: '',
          email: '',
          introduction: '',
          name: '',
          nickname: '',
          password: '',
          phone: '',
          realname: '',
          sex: '',
          signature: ''
        },
        rules: {
          email: 'required|email',
          name: 'required',
          password: 'required'
        }
      }
    },
    mounted () {
      this.$store.commit('title', '创建用户 - 用户中心 - Notadd Administration')
    }
  }
</script>
<template>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">添加用户</h3>
        </div>
        <div class="box-body">
            <div class="form-horizontal" @keyup.enter="submit">
                <div class="form-group" :class="{ 'has-error': errors.has('name') }">
                    <label class="col-sm-1 control-label">用户名</label>
                    <div class="col-sm-3">
                        <input name="name" type="text" class="form-control" placeholder="请输入用户名" v-model="user.name" v-validate="rules.name">
                    </div>
                    <div class="col-sm-8">
                        <span class="help-block" v-show="errors.has('name')">用户名不能为空</span>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error': errors.has('name') }">
                    <label class="col-sm-1 control-label">用户密码</label>
                    <div class="col-sm-3">
                        <input name="password" type="text" class="form-control" placeholder="请输入用户密码" v-model="user.nickname">
                    </div>
                    <div class="col-sm-8">
                        <span class="help-block" v-show="errors.has('password')">用户密码不能为空</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">昵称</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="请输入昵称" v-model="user.nickname">
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">真实姓名</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="请输入真实姓名" v-model="user.realname">
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">电子邮件</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="请输入电子邮件" v-model="user.email">
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">电话号码</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="请输入电话号码" v-model="user.phone">
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">真实姓名</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="请输入真实姓名" v-model="user.realname">
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">用户介绍</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" rows="6" placeholder="请输入用户介绍" v-model="user.introduction"></textarea>
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">签名</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" rows="6" placeholder="请输入签名" v-model="user.signature"></textarea>
                    </div>
                    <div class="col-sm-8"></div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary btn-submit" @click="submit" :disabled="errors.any()">保存</button>
        </div>
    </div>
</template>