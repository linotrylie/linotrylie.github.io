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
            height: 500px;
        }

        body > .el-container {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div id="app">
<el-container>
    <el-header>文件批量修改器</el-header>
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
            <el-form-item>
                <el-button type="primary" @click="onSubmit">查询</el-button>
            </el-form-item>
        </el-form>
    </el-main>
    <el-footer><?php echo $copy;?></el-footer>
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
                    passport:"<?php echo $rsf;?>"
                }
            }
        },
        methods: {
            onSubmit() {
                axios.get('/stasf/sesdfc', {
                    params: {
                        filename:this.formInline.filename,
                        path: this.formInline.path,
                        passport:this.formInline.passport
                    }
                }).then(function (response) {
                        console.log(response);
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