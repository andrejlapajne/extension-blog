<?php

namespace Pagekit\Blog\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@blog_category")
 */
class Category implements \JsonSerializable
{
    use ModelTrait;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column(type="string") */
    public $name;

    /** @Column(type="string") */
    public $slug;

    /**
     * @HasMany(targetEntity="Post", keyFrom="id", keyTo="category_id")
     */
    public $posts;

    /** @var array */
    protected static $properties = [
        'postsCount' => 'getPostsCount'        
    ];
    
    /**
     * @Saving
     */
    public static function saving($event, $category)
    {
        // Ensure unique slug
        $i = 2;
        $id = $category->id;
        if (!$category->slug) {
            $category->slug = $category->name;
        }
        while (self::where(['slug = ?'], [$category->slug])->where(function ($query) use ($id) {
            if ($id) {
                $query->where('id <> ?', [$id]);
            }
        })->first()) {
            $category->slug = preg_replace('/-\d+$/', '', $category->slug).'-'.$i++;
        }
    }

    public function getPostsCount() {
        return $this->posts ? $this->posts->count() : 0;
    }
}
