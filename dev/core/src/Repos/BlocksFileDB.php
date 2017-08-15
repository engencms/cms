<?php namespace Engen\Repos;

use Engen\Entities\Block;
use Maer\FileDB\FileDB;

class BlocksFileDB implements BlocksInterface
{
    /**
     * @var FileDB
     */
    protected $db;

    /**
     * @var string
     */
    protected $contentPath;

    /**
     * @var array
     */
    protected $blocks = [];

    /**
     * List of matching blocks key => id
     * @var array
     */
    protected $blockKeys = [];


    /**
     * @param FileDB $db
     * @param string $contentPath
     */
    public function __construct(FileDB $db, $contentPath)
    {
        $this->db = $db;
        $this->contentPath = $contentPath;

        $this->loadBlocks();
    }


    /**
     * Get list of all blocks
     *
     * @return array
     */
    public function getBlocks()
    {
        return array_values($this->blocks);
    }


    /**
     * Get a block by id
     *
     * @param  integer $id
     * @return Block|null
     */
    public function getBlockById($id)
    {
        $block = $this->blocks[$id] ?? null;
        if ($block) {
            $block->content = $this->getBlockContent($id);
        }

        return $block;
    }


    /**
     * Get a block by key
     *
     * @param  string $key
     * @return string|null
     */
    public function getBlockByKey($key)
    {
        return $this->getBlockById($this->blockKeys[$key] ?? null);
    }


    /**
     * Get block content
     *
     * @param  string $id
     * @return array
     */
    public function getBlockContent($id)
    {
        $file = $this->contentPath . "/{$id}.json";
        if (is_file($file)) {
            $content = json_decode(file_get_contents($file), true);
        }

        return empty($content) || !is_array($content)
            ? []
            : $content;
    }


    /**
     * Update a block
     *
     * @param  string $id
     * @param  array  $info
     * @param  array  $content
     * @return Block|null
     */
    public function updateBlock($id, array $info, array $content)
    {
        if (!$block = $this->blocks[$id] ?? null) {
            return false;
        }

        $file = $this->contentPath . "/{$id}.json";
        if (file_put_contents($file, json_encode($content)) < 1) {
            return false;
        }

        if (empty($info['updated'])) {
            $info['updated'] = time();
        }

        if ($block->created == 0) {
            $block->created = time();
        }

        $data = array_replace($block->toArray(['id', 'content']), $info);

        if ($this->db->blocks->where('id', $id)->update($data) < 1) {
            return false;
        }

        $this->loadBlocks();
        return $this->blocks[$id] ?? false;
    }


    /**
     * Add a new block
     *
     * @param  Block   $block
     * @param  array  $content
     * @return Block|null
     */
    public function createBlock(Block $block, array $content)
    {
        $block->created = (int) $block->created > 0 ? $block->created : time();
        $block->updated = (int) $block->updated > 0 ? $block->updated : time();

        if (!$id = $this->db->blocks->insert($block->toArray(['id', 'content']))) {
            return false;
        }

        $file = $this->contentPath . "/{$id}.json";
        if (file_put_contents($file, json_encode($content)) < 1) {
            return false;
        }

        $this->loadBlocks();
        return $this->blocks[$id] ?? false;
    }


    /**
     * Load block list
     */
    protected function loadBlocks()
    {
        $this->blocks      = [];
        $this->blockKeys   = [];

        $blocks = $this->db->blocks
            ->asObj('Engen\Entities\Block')
            ->orderBy('name', 'asc')->get();

        foreach ($blocks as $item) {
            $this->blocks[$item->id]     = $item;
            $this->blockKeys[$item->key] = $item->id;
        }
    }
}
