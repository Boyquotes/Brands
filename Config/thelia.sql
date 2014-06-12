
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- brand
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand`
(
    `id` INTEGER NOT NULL,
    `nom` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `id`
        FOREIGN KEY (`id`)
        REFERENCES `product` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
