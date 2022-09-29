<?php

namespace App\Manager;

class ExpeditionManager
{
    public function getnumberOfPiecesPerUnit(float $expeditionQuantity, float $quantityPerPiece): float
    {
        return $expeditionQuantity / $quantityPerPiece;
    }

    public function isRightNumberOfPiecesPerUnit(float $numberOfPiecesPerUnit, float $expeditionQuantity): bool
    {
        if (floor($numberOfPiecesPerUnit) == $numberOfPiecesPerUnit && $expeditionQuantity != 0) {
            return true;
        } else {
            return false;
        }
    }
}
