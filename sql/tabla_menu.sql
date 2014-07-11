-- -----------------------------------------------------

-- Table `smeagol`.`menu`

-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `smeagol`.`menu` (

  `id` INT NOT NULL AUTO_INCREMENT ,

  `name` VARCHAR(100) NULL ,

  `parent_id` INT NOT NULL DEFAULT 0 ,

  `order_id` INT NOT NULL DEFAULT 0 ,

  `node_id` INT NOT NULL ,

  PRIMARY KEY (`id`) ,

  INDEX `fk_menu_node1_idx` (`node_id` ASC) ,

  CONSTRAINT `fk_menu_node1`

    FOREIGN KEY (`node_id` )

    REFERENCES `smeagol`.`node` (`id` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION)

ENGINE = InnoDB;