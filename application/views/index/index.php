<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件修改</title>
    <!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <style>

        .el-header, .el-footer {
            background-color: #B3C0D1;
            color: #333;
            text-align: center;
            line-height: 60px;
        }
        .el-main {
            background-color: #E9EEF3;
            color: #333;
            text-align: center;
            height: auto;
        }
        .el-table{
            margin: 0 auto 0 auto;
        }
        body > .el-container {
            margin: auto 0 auto 0;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div id="app">
<el-container>
    <el-header>文件批量修改器----<?php echo $copy;?></el-header>
    <el-main>
        <el-form :inline="true" :model="formInline" class="demo-form-inline">
            <el-form-item>
                <el-input v-model="formInline.passport" value="<?php echo md5($rsf);?>" type="hidden"></el-input>
            </el-form-item>
            <el-form-item label="搜索文件名">

                <el-input v-model="formInline.filename" placeholder="（例如:index.html）" ></el-input>
            </el-form-item>
            <el-form-item label="搜索区域">
                <el-select v-model="formInline.path" placeholder="搜索区域">
                    <?php foreach ($mulu as $v): ?>
                    <el-option label="<?=$v;?>" value="<?=$v;?>"></el-option>
                    <?php endforeach;?>
                </el-select>
            </el-form-item>
            <el-form-item label="插入位置">
                <el-select v-model="formInline.location" placeholder="搜索区域">
                    <el-option label="顶部" value="1"></el-option>
                    <el-option label="底部" value="0"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button
                        v-loading.fullscreen.lock="fullscreenLoading"
                        type="primary"
                        @click="onSubmit">
                    插入</el-button>
            </el-form-item>
            <br>
            <el-form-item label="插入代码">
                <el-input
                  type="textarea"
                  :rows="10"
                  :cols="60"
                  placeholder="请输入内容"
                  v-model="formInline.code">
                </el-input>
               
            </el-form-item>

        </el-form>
        <template>
            <p v-if="textData > 1">本次共修改文件{{textData}}个</p>
            <el-table
                    :data="tableData"
                    stripe
                    style="width: 50%">
                <el-table-column
                        prop="filename"
                        label="文件名"
                        width="300%">
                </el-table-column>
                <el-table-column
                        prop="ext"
                        label="类型"
                        width="300%">
                </el-table-column>
                <el-table-column
                        prop="status"
                        label="状态"
                        width="300%">
                </el-table-column>
            </el-table>
        </template>
    </el-main>
    <!-- <el-footer></el-footer> -->
</el-container>
</div>
</body>
<!-- import Vue before Element -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- import JavaScript -->
<script src='https://unpkg.com/axios@0.18.0/dist/axios.min.js'></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script>
    var Main = {
        data() {
            return {
                formInline: {
                    filename: '',
                    path:'',
                    code:'',
                    location:'',
                    passport:"<?php echo $rsf;?>"
                },
                tableData: [{
                    filename: 'index.html',
                    ext: 'html',
                    status:'成功'
                }],
                fullscreenLoading: false,
                textData:'0'
            }
        },
        methods: {
            onSubmit() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                setTimeout(() => {
                    loading.close();
                },5000);
                axios.get('/stasf/sesdfc', {
                    params: {
                        filename:this.formInline.filename,
                        path: this.formInline.path,
                        code:this.formInline.code,
                        location:this.formInline.location,
                        passport:this.formInline.passport
                    }
                }).then(result => {
                       this.tableData = result.data.result.file;
                       this.textData = result.data.result.count;
                }).catch(function (error) {
                        console.log(error);
                });
            }
        }
    } 
    var Ctor = Vue.extend(Main)
    new Ctor().$mount('#app')
</script>
</html>