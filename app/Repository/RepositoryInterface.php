<?php
namespace App\Repository;

interface RepositoryInterface {

	public function getItem();

	public function getItemById($id);

	public function getItemBySlug($slug);

	public function getPurchase();

	public function getPurchaseById($id);

	public function getPurchaseBySlug($id);

}