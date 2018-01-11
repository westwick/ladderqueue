<template>
    <div class="row">
        <div class="small-12 columns">
            <template v-if="isAdmin">
                <div class="panel nmt">
                    <h6>Post News Article</h6>
                    <input type="text" placeholder="Title" v-model="title" />
                    <textarea placeholder="post content goes here" v-model="body"></textarea>
                    <button class="button nomargin" :disabled="loading" @click="postNews()">
                        {{ !loading ? 'Post' : 'Posting...' }}
                    </button>
                </div>
            </template>
            <template v-else>
                <p class="text-center; font-size: 25px">Unauthorized</p>
            </template>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                loading: false,
                title: '',
                body: ''
            }
        },
        computed: {
            isAdmin() {
                return this.$store.state.is_admin
            }
        },
        methods: {
            postNews() {
                if(this.title.length < 3 || this.body.length < 3) {
                    toastr.error('you must enter a title and body')
                    return false
                }
                this.loading = true
                var title = this.title
                var body = this.body
                this.$http.post('/admin/news', {title, body}).then((response) => {
                    this.loading = false
                    window.location.href='/'
                }, (response) => {
                    toastr.error('something went wrong')
                    this.loading = false
                })
            }
        }
    }
</script>
