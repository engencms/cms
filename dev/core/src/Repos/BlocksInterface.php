<?php namespace Engen\Repos;

use Engen\Entities\Block;

interface BlocksInterface
{
    /**
     * Get list of all blocks
     *
     * @return array
     */
    public function getBlocks();


    /**
     * Get a block by id
     *
     * @param  integer $id
     * @return Block|null
     */
    public function getBlockById($id);


    /**
     * Get a block by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getBlockByKey($key);


    /**
     * Get block content
     *
     * @param  string $id
     * @return array
     */
    public function getBlockContent($id);


    /**
     * Update a block
     *
     * @param  string $id
     * @param  array  $info
     * @param  array  $content
     * @return Block|null
     */
    public function updateBlock($id, array $info, array $content);


    /**
     * Add a new block
     *
     * @param  Block   $block
     * @param  array  $content
     * @return Block|null
     */
    public function createBlock(Block $block, array $content);
}
