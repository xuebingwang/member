<script>
  import Core from '../main'
  export default {
    beforeRouteEnter (to, from, next) {
      Core.http.post(window.api + '/member/groups/' + to.params.id + '/show').then((response) => {
        console.log(response)
        next((vm) => {
          vm.group.description = response.data.data.description
          vm.group.display = response.data.data.display_name
          vm.group.identification = response.data.data.name
        })
      })
    },
    data () {
      return {
        group: {
          description: '',
          display: '',
          identification: ''
        },
        rules: {
          display: 'required',
          identification: 'required'
        }
      }
    },
    methods: {
      submit: function () {
        let _this = this
        _this.$validator.validateAll()
        if (_this.errors.any()) {
          return false
        }
        _this.$http.patch(window.api + '/member/groups/store', {
          name: _this.group.identification,
          display_name: _this.group.display,
          description: _this.group.description
        }).then((response) => {
          if (response.status === 204) {
            _this.$router.push('/member/group')
            _this.$store.commit('message', {
              show: true,
              type: 'notice',
              text: '编辑用户组成功！'
            })
          }
        })
      }
    },
    mounted () {
      this.$store.commit('title', '编辑用户组 - 用户中心 - Notadd Administration')
    }
  }
</script>
<template>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">添加用户组</h3>
        </div>
        <div class="box-body">
            <div class="form-horizontal" @keyup.enter="submit">
                <div class="form-group" :class="{ 'has-error': errors.has('identification') }">
                    <label class="col-sm-1 control-label">用户组标识</label>
                    <div class="col-sm-3">
                        <input name="identification" type="text" class="form-control" placeholder="请输入用户组标识" v-model="group.identification" v-validate="rules.identification">
                    </div>
                    <div class="col-sm-8">
                        <span class="help-block" v-show="errors.has('identification')">用户组标识不能为空</span>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error': errors.has('display') }">
                    <label class="col-sm-1 control-label">显示名称</label>
                    <div class="col-sm-3">
                        <input name="display" type="text" class="form-control" placeholder="请输入用户组标识" v-model="group.display" v-validate="rules.display">
                    </div>
                    <div class="col-sm-8">
                        <span class="help-block" v-show="errors.has('display')">显示名称不能为空</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">用户组描述</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" rows="6" placeholder="请输入用户组描述" v-model="group.description"></textarea>
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