<template>
    <div class="caption">
        <input type="file" ref="file" accept="image/*" @change="onFileChange($event)">
        <p>
            <img class="change-file" :src="imageData" v-if="imageData">
        </p>
        <button class="btn btn-danger" v-if="imageData" v-on:click.prevent="resetFile()">リセットする</button>
    </div>
</template>>

<script>
    export default {
        data() {
            return {
                imageData: '',
            }
        },
        methods: {
            // 選択した画像のプレビュー機能
            onFileChange(e) {
                const files = e.target.files;

                if(files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageData = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            // ファイルのリセット処理
            resetFile() {
                const input = this.$refs.file;
                // インプット要素のtypeを一度textに変更して元に戻すことでリセットを実装
                input.type = 'text';
                input.type = 'file';
                this.imageData = '';
                
            }
        }
    }
</script>