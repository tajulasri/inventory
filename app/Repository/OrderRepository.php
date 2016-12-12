<?php
namespace App\Repository;

use App\Entity\Item;
use App\Entity\Purchase;
use App\Entity\Category;

class OrderRepository implements RepositoryInterface {

	private $item;

	private $purchase;

	private $category;
	
	private $limitPerPage = 10;

	const DESC = 'desc';

	public function __construct(Item $item,Purchase $purchase,Category $category)
	{
		$this->item = $item;
		$this->purchase = $purchase;
		$this->category = $category;
	}

	/**
	 * get item
	 * @return QueryBuilder $queryBuilder
	 */
	public function getItem()
	{
		return $this->item->orderBy($this->item->getKeyName(),self::DESC);
	}

	public function getItemById($id)
	{
		return $this->item->findOrFail($id);
	}

	public function getItemBySlug($slug)
	{
		return $this->item->where('item_slug',$slug)->first();
	}

	public function getPurchase()
	{
		return $this->purchase->orderBy($this->purchase->getKeyName(),self::DESC);
	}

	public function getPurchaseById($id)
	{
		return $this->purchase->findOrFail($id);
	}

	public function getPurchaseBySlug($id)
	{

	}

	public function setPaginationLimit($limit)
	{
		$this->limitPerPage = $limit;
	}

	public function getPaginationLimit()
	{
		return $this->limitPerPage;
	}

	public function getItemModel()
	{
		return $this->item;
	}

}