<template>

    <div class="uk-form-row">
        <label for="form-link-blog" class="uk-form-label">{{ 'View' | trans }}</label>
        <div class="uk-form-controls">
            <select id="form-link-blog" class="uk-width-1-1" v-model="link">
                <option value="@blog">{{ 'Posts View' | trans }}</option>
                <optgroup :label="'Posts' | trans">
                    <option v-for="p in posts" :value="p | postlink">{{ p.title }}</option>
                </optgroup>
                <optgroup :label="'Categories' | trans">
                    <option v-for="c in categories" :value="c | categorylink">{{ c.name }}</option>
                </optgroup>
            </select>
        </div>
    </div>

</template>

<script>

    module.exports = {

        link: {
            label: 'Blog'
        },

        props: ['link'],

        data: function () {
            return {
                posts: [],
                categories: []
            }
        },

        created: function () {
            // TODO: Implement pagination or search
            this.$http.get('api/blog/post', {filter: {limit: 1000}}).then(function (res) {
                this.$set('posts', res.data.posts);
            });
            this.$http.get('api/blog/category', {filter: {limit: 1000}}).then(function (res) {
                this.$set('categories', res.data.categories);
            });
        },

        ready: function() {
            this.link = '@blog';
        },

        filters: {

            postlink: function (post) {
                return '@blog/id?id=' + post.id;
            },
            categorylink: function (category) {
                return '@blog/category?id=' + category.id;
            }

        }

    };

    window.Links.components['link-blog'] = module.exports;

</script>
