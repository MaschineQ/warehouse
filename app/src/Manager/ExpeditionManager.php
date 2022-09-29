<?php

namespace App\Manager;

use App\Entity\ExpeditionItem;

class ExpeditionManager
{
    public function getnumberOfPiecesPerUnit(int $expeditionQuantity, int $quantityPerPiece): int
    {
        return $expeditionQuantity / $quantityPerPiece;
    }

    public function isRightNumberOfPiecesPerUnit(int $numberOfPiecesPerUnit, float $expeditionQuantity): bool
    {
        if (floor($numberOfPiecesPerUnit) == $numberOfPiecesPerUnit && $expeditionQuantity != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function create(ExpeditionItem $expeditionItem)
    {
    }
}
