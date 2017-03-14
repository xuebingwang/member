<script>
  import Core from '../main'
  export default {
    beforeRouteEnter (to, from, next) {
      Core.http.post(window.api + '/member/members/index').then((response) => {
        console.log(response)
        next((vm) => {
          vm.list = response.data.data
        })
      })
    },
    data () {
      return {
        list: []
      }
    },
    methods: {
      groupSelected: function (e) {},
      paginator: function (page) {
      },
      search: function () {}
    }
  }
</script>
<style scoped>
    .box {
        border-top: none;
        padding-left: 40px;
        padding-right: 40px;
    }

    .box-body {
        border-bottom: 1px solid #eeeeee;
        border-radius: 0;
        border-top: 1px solid #eeeeee;
    }

    .box-body > .table > tbody > tr > td {
        border-color: #eeeeee;
        height: 60px;
        vertical-align: middle;
    }

    .box-body > .table > tbody > tr > td:last-child {
        letter-spacing: 6px;
        text-align: right;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn {
        border-radius: 4px;
        letter-spacing: 0;
        padding: 5px 12px;
    }

    .box-footer {
        text-align: right;
    }

    .box-footer,
    .box-header {
        height: 80px;
        padding: 23px 0;
        position: relative;
    }

    .box-header > .box-search {
        float: left;
        width: 320px;
    }

    .box-header > .box-search > .form-control {
        border-bottom-left-radius: 18px;
        border-color: #cccccc;
        border-right-width: 0;
        border-top-left-radius: 18px;
    }

    .box-header > .box-search > .input-group-btn {
        border: 1px solid #cccccc;
        border-bottom-right-radius: 18px;
        border-left-width: 0;
        border-top-right-radius: 18px;
        overflow: hidden;
    }

    .box-header > .box-search > .input-group-btn > .btn {
        padding-bottom: 6px;
        padding-top: 6px;
        width: 60px;
    }

    .box-header > .box-extend {
        letter-spacing: 16px;
        text-align: right;
    }

    .box-header > .box-extend > .btn {
        border-radius: 6px;
        padding: 6px 32px;
    }

    .box-header > .box-extend > .form-control {
        display: inline-block;
        vertical-align: middle;
        width: 140px;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn,
    .box-header > .box-extend > .btn {
        background: #ffffff;
        border-width: 1px;
        color: #000000;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-primary,
    .box-header > .box-extend > .btn-primary {
        border-color: #3498db;
        color: #3498db;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-primary:hover,
    .box-header > .box-extend > .btn-primary:hover {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-info,
    .box-header > .box-extend > .btn-info {
        border-color: #8ba0ca;
        color: #8ba0ca;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-info:hover,
    .box-header > .box-extend > .btn-info:hover {
        background-color: #8ba0ca;
        border-color: #8ba0ca;
        color: #ffffff;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-danger,
    .box-header > .box-extend > .btn-danger {
        border-color: #ef5151;
        color: #ef5151;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-danger:hover,
    .box-header > .box-extend > .btn-danger:hover {
        background-color: #ef5151;
        border-color: #ef5151;
        color: #ffffff;
    }

    .box-header > .box-extend > .btn {
        letter-spacing: 0;
    }

    .box-header > .box-extend > .btn-create {
        background: #3498db;
        color: #ffffff;
        letter-spacing: 0;
    }

    .box-header > .box-extend > .btn-create:hover {
        background: #258cd1;
    }

    .box-header > .box-extend > .btn-create:active,
    .box-header > .box-extend > .btn-create:focus {
        background: #2b7cb3;
    }
</style>
<template>
    <div class="box">
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <colgroup>
                    <col class="col-md-3">
                    <col class="col-md-3">
                    <col class="col-md-3">
                    <col class="col-md-3">
                </colgroup>
                <thead>
                <tr>
                    <th>信息</th>
                    <th>是否启用</th>
                    <th>数值</th>
                    <th>备注</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>