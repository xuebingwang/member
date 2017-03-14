<script>
  export default {
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

      }
    },
    mounted () {
      this.$store.commit('title', '创建用户组 - 用户中心 - Notadd Administration')
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
                        <input name="identification" type="text" class="form-control" placeholder="请输入用户组标识" v-model="identification" v-validate="rules.identification">
                    </div>
                    <div class="col-sm-8">
                        <span class="help-block" v-show="errors.has('identification')">用户组标识不能为空</span>
                    </div>
                </div>
                <div class="form-group" :class="{ 'has-error': errors.has('display') }">
                    <label class="col-sm-1 control-label">显示名称</label>
                    <div class="col-sm-3">
                        <input name="display" type="text" class="form-control" placeholder="请输入用户组标识" v-model="display" v-validate="rules.display">
                    </div>
                    <div class="col-sm-8">
                        <span class="help-block" v-show="errors.has('display')">显示名称不能为空</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">用户组描述</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" rows="6" placeholder="请输入用户组描述" v-model="description"></textarea>
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