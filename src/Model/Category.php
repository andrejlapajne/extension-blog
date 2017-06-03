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
     * @HasMany(targetEntity="Posts", keyFrom="id", keyTo="category_id")
     */
    public $posts;
    
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
}
