-- Migration: Add stok column to obat table
-- Purpose: Support stock management for medicines

ALTER TABLE `obat` ADD COLUMN `stok` INT(11) NOT NULL DEFAULT 0 AFTER `harga`;

-- Set default stock for existing medicines (optional)
UPDATE `obat` SET `stok` = 100 WHERE `stok` = 0;
