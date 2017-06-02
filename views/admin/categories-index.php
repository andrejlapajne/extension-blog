<?php $view->script('categories-index', 'blog:app/bundle/categories-index.js', 'vue') ?>

<div id="category" class="uk-form" v-cloak>

    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

            <h2 class="uk-margin-remove" v-if="!selected.length">{{ '{0} %count% Categories|{1} %count% Category|]1,Inf[ %count% Categories' | transChoice count {count:count} }}</h2>

            <template v-else>
                <h2 class="uk-margin-remove">{{ '{1} %count% Category selected|]1,Inf[ %count% Categories selected' | transChoice selected.length {count:selected.length} }}</h2>

                <div class="uk-margin-left" >
                    <ul class="uk-subnav pk-subnav-icon">
                        <li><a class="pk-icon-copy pk-icon-hover" title="Copy" data-uk-tooltip="{delay: 500}" @click="copy"></a></li>
                        <li><a class="pk-icon-delete pk-icon-hover" title="Delete" data-uk-tooltip="{delay: 500}" @click="remove" v-confirm="'Delete Categories?'"></a></li>
                    </ul>
                </div>
            </template>

            <div class="pk-search">
                <div class="uk-search">
                    <input class="uk-search-field" type="text" v-model="config.filter.search" debounce="300">
                </div>
            </div>

        </div>
        <div data-uk-margin>

            <a class="uk-button uk-button-primary" :href="$url.route('admin/blog/category/edit')">{{ 'Add Category' | trans }}</a>

        </div>
    </div>

    <div class="uk-overflow-container">
        <table class="uk-table uk-table-hover uk-table-middle">
            <thead>
                <tr>
                    <th class="pk-table-width-minimum"><input type="checkbox" v-check-all:selected.literal="input[name=id]" number></th>
                    <th class="pk-table-min-width-200" v-order:title="config.filter.order">{{ 'Name' | trans }}</th>
                    <th class="pk-table-width-200 pk-table-min-width-200">{{ 'Slug' | trans }}</th>
                    <th class="pk-table-width-100">{{ '# Posts' | trans }}</th>
                </tr>
            </thead>
            <tbody>
                <tr class="check-item" v-for="category in categories" :class="{'uk-active': active(category)}">
                    <td><input type="checkbox" name="id" :value="category.id"></td>
                    <td>
                        <a :href="$url.route('admin/blog/category/edit', { id: category.id })">{{ category.name }}</a>
                    </td>
                    <td>
                        {{ category.slug }}
                    </td>
                    <td>
                        {{ category.posts.length }}
                    </td>                                        
                </tr>
            </tbody>
        </table>
    </div>

    <h3 class="uk-h1 uk-text-muted uk-text-center" v-show="categories && !categories.length">{{ 'No categories found.' | trans }}</h3>

    <v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1 || page > 0"></v-pagination>

</div>