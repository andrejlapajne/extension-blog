<?php
namespace Pagekit\Blog\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@blog_post_categories")
 */
class PostCategories implements \JsonSerializable
{
    use ModelTrait;

    /** @Column(type="integer") @Id */
    public $id;
    
    /** @Column(type="integer") */
    public $post_id;
    
    /** @Column(type="integer") */
    public $category_id;
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
