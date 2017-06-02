<template>

    <div class="uk-form-horizontal">

        <div class="uk-form-row">
            <label for="form-meta-name" class="uk-form-label">{{ 'Name' | trans }}</label>
            <div class="uk-form-controls">
                <input id="form-meta-name" class="uk-form-width-large" type="text" v-model="category.name">
            </div>
        </div>

        <div class="uk-form-row">
            <label for="form-meta-slug" class="uk-form-label">{{ 'Slug' | trans }}</label>
            <div class="uk-form-controls">
                <input id="form-meta-slug" class="uk-form-width-large" type="text" v-model="category.slug"></input>
            </div>
        </div>

    </div>

</template>

<script>

    module.exports = {

        section: {
            label: 'Category'
        },

        props: ['category']

    };

</script>
