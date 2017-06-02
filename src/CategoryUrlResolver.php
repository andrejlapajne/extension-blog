<?php
namespace Pagekit\Blog;

use Pagekit\Application as App;
use Pagekit\Blog\Model\Category;
use Pagekit\Blog\Model\Post;
use Pagekit\Routing\ParamsResolverInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class CategoryUrlResolver implements ParamsResolverInterface
{
    const CACHE_KEY = 'blog.routing.category';

    /**
     * @var bool
     */
    protected $cacheDirty = false;
    
    /**
     * @var array
     */
    protected $cacheEntries;
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->cacheEntries = App::cache()->fetch(self::CACHE_KEY) ?: [];
    }
    
    /**
     * {@inheritdoc}
     */
    public function match(array $parameters = [])
    {
        if (isset($parameters['id'])) {
            return $parameters;
        }
        if (!isset($parameters['category'])) {
            App::abort(404, 'Category not found.');
        }
        $slug = $parameters['category'];
        $id = false;
        foreach ($this->cacheEntries as $entry) {
            if ($entry['slug'] === $slug) {
                $id = $entry['id'];
            }
        }
        if (!$id) {
            if (!$category = Category::where(compact('slug'))->first()) {
                App::abort(404, 'Category not found.');
            }
            $this->addCache($category);
            $id = $category->id;
        }
        $parameters['id'] = $id;
        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(array $parameters = [])
    {
        $id = $parameters['id'];
        if (!isset($this->cacheEntries[$id])) {
            if (!$category = Category::where(compact('id'))->first()) {
                throw new RouteNotFoundException('Category not found!');
            }
            $this->addCache($category);
        }
        $meta = $this->cacheEntries[$id];
        $parameters['category'] = $meta['slug'];
        unset($parameters['id']);
        return $parameters;
    }

    public function __destruct()
    {
        if ($this->cacheDirty) {
            App::cache()->save(self::CACHE_KEY, $this->cacheEntries);
        }
    }

    protected function addCache($category)
    {
        $this->cacheEntries[$category->id] = [
            'id'     => $category->id,
            'slug'   => $category->slug
        ];
        $this->cacheDirty = true;
    }
}
