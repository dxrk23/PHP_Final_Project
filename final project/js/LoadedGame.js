class LoadedGame extends Phaser.Scene {
    constructor() {
      super("PlayGame");
    }
    create() {
      try {
        this.background = this.add.tileSprite(0, 0, game.config.width, game.config.height, "background"); //add background and do it repeated
        this.background.setOrigin(0, 0); //set background started from (0,0)

        this.tank_red_1 = this.physics.add.sprite((config.width * 3) / 4 + 50, config.height / 2, "tank_red_1"); //add tank_1 object
        this.tank_blue_1 = this.physics.add.sprite(config.width / 4 - 50, config.height / 2, "tank_blue_1");
        this.pregradi = this.physics.add.group();
        this.red_barrels = this.physics.add.group();
      } catch (e) {
        console.log("Error with init. game objects");
      }
      try {
        for (var i = 0; i < gameSetting.maxRedBarrels; i++) {
          var RedBarrel = this.physics.add.sprite(48, 48, "red_barrel");
          RedBarrel.setScale(0.5);
          this.red_barrels.add(RedBarrel);
          RedBarrel.setRandomPosition(0, 0, game.config.width, game.config.height);
          RedBarrel.setCollideWorldBounds(true);
        }
      } catch (e) {
        console.log("Error with barrels spawn");
      }

      try {
        for (let i = 0; i <= 380; i += 76) {
          var Pregrada = this.physics.add.sprite(128, 128, "pregrada");
          Pregrada.setCollideWorldBounds(true);
          Pregrada.setScale(0.6);
          this.pregradi.add(Pregrada);
          Pregrada.setPosition(config.width / 4 + 100, 180 + i);
        }

        for (let i = 0; i <= 380; i += 76) {
          var Pregrada = this.physics.add.sprite(128, 128, "pregrada");
          Pregrada.setCollideWorldBounds(true);
          Pregrada.setScale(0.6);
          this.pregradi.add(Pregrada);
          Pregrada.setPosition((config.width * 3) / 4 - 100, 180 + i);
        }
      } catch (e) {
        console.log("Error with spawning pregradi");
      }


      this.tank_red_1.setScale(0.2); // make it smaller
      this.tank_red_1.setCollideWorldBounds(true); //make tank_1 not go out of bounds
      this.tank_blue_1.setScale(0.2); // make it smaller
      this.tank_blue_1.setCollideWorldBounds(true); //make tank_2 not go out of bounds

      try {
        this.cursorKeys = this.input.keyboard.createCursorKeys(); //object of class cursorkeys
        this.spacebar = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.SPACE);
        this.enter = this.input.keyboard.addKey(Phaser.Input.Keyboard.KeyCodes.ENTER);
        this.WASD = this.input.keyboard.addKeys("W, A , S , D,");
      } catch (e) {
        console.log("Error with key classes init");
      }

      this.background_music = this.sound.add("background_music"); //add background music

      this.background_music.play(musicConfig); // play music
      if (game.sound.context.state === 'suspended') game.sound.context.resume();

      try {

        this.physics.add.collider(this.tank_red_1, this.pregradi, function(tank, pregrada) {
          pregrada.body.immovable = true;
          pregrada.body.moves = false;
        });

        this.physics.add.collider(this.tank_blue_1, this.pregradi, function(tank, pregrada) {
          pregrada.body.immovable = true;
          pregrada.body.moves = false;
        });

        this.physics.add.collider(this.tank_red_1, this.red_barrels, function(tank_red_1, RedBarrel) {
          RedBarrel.setVelocity(0);
        });

        this.physics.add.collider(this.red_barrels, this.pregradi, function(barrel, pregrada) {
          pregrada.body.immovable = true;
          pregrada.body.moves = false;
          // barrel.body.immovable = true;
          // barrel.body.moves = false;
        });

        this.physics.add.collider(this.tank_blue_1, this.red_barrels, function(tank_blue_1, RedBarrel) {
          RedBarrel.setVelocity(0);
        });

        this.physics.add.collider(this.tank_red_1, this.tank_blue_1, function(red_tank, blue_tank) {
          blue_tank.setVelocity(0);
        });

        this.physics.add.collider(this.red_barrels, this.red_barrels);

        this.utilities = this.add.group();

        this.physics.add.collider(this.utilities, this.red_barrels, function(bullet, RedBarrel) {
          RedBarrel.destroy();
          bullet.destroy();
        });


        this.physics.add.collider(this.utilities, this.pregradi, function(utility, pregrada) {
          pregrada.body.immovable = true;
          pregrada.body.moves = false;
          utility.destroy();
        });

        this.physics.add.collider(this.utilities, this.tank_blue_1, function(bullet, tank) {
          bullet.destroy();
          gameSetting.redScore += 100;
          config.newRound = true;
        });

        this.physics.add.collider(this.utilities, this.tank_red_1, function(bullet, tank) {
          bullet.destroy();
          gameSetting.blueScore += 100;
          config.newRound = true;
        });

        this.physics.add.collider(this.utilities, this.utilities, function(bullet, bullet2) {
          bullet.destroy();
          bullet2.destroy();
        });
      } catch (e) {
        console.log("Error with physic logics");
      }

    }

    update() {
        if (config.newRound) {
          this.tank_blue_1.setX(config.width / 4 - 50);
          this.tank_blue_1.setY(config.height / 2);
          this.tank_red_1.setY(config.height / 2);
          this.tank_red_1.setX((config.width * 3) / 4 + 50);

          config.newRound = false;
        }
        if (gameSetting.blueScore == 300) {
            alert("Blue won with score " + gameSetting.blueScore + " : " + gameSetting.redScore);
            alert("New game started");
            config.newRound = true;
            gameSetting.blueScore = 0;
            gameSetting.redScore = 0;
          }
          if (gameSetting.redScore == 300) {
              alert("Blue won with score " + gameSetting.blueScore + " : " + gameSetting.redScore);
              alert("New game started");
              config.newRound = true;
              gameSetting.blueScore = 0;
              gameSetting.redScore = 0;
            }
            this.RedTankMovementLogic(); this.BlueTankMovementLogic();

            if (Phaser.Input.Keyboard.JustDown(this.spacebar)) {
              this.ShootTankBlue();
            }
            if (Phaser.Input.Keyboard.JustDown(this.enter)) {
              this.ShootTank();
            }
          }

          ShootTankBlue() {
            var bluebullet = new BulletBlue(this);
            bluebullet.setScale(0.4);
            //bluebullet.play('fire');
          }

          ShootTank() {
            var bullet = new Bullet(this);
            bullet.setScale(0.4);
            //bullet.play('fire');
          }

          BlueTankMovementLogic() {
            this.tank_blue_1.setVelocity(0);

            if (this.WASD.W.isDown === true) {
              this.tank_blue_1.setVelocityY(-gameSetting.tankSpeed); // set movement over axis y , velosity is directed to upward
              this.tank_blue_1.angle = 180;
            } else if (this.WASD.D.isDown === true) {
              this.tank_blue_1.setVelocityX(gameSetting.tankSpeed); // set movement over axis x , velosity is directed to right
              this.tank_blue_1.angle = -90;
            } else if (this.WASD.S.isDown === true) {
              this.tank_blue_1.setVelocityY(gameSetting.tankSpeed); // set movement over axis y , velosity is directed to upward
              this.tank_blue_1.angle = 0;
            } else if (this.WASD.A.isDown === true) {
              this.tank_blue_1.setVelocityX(-gameSetting.tankSpeed); // set movement over axis x , velosity is directed down
              this.tank_blue_1.angle = 90;
            }
          }

          RedTankMovementLogic() {
            this.tank_red_1.setVelocity(0);

            if (this.cursorKeys.left.isDown) {
              this.tank_red_1.setVelocityX(-gameSetting.tankSpeed); // set movement over axis x , velosity is directed to left
              this.tank_red_1.angle = 90; //set direction of the object
            } else if (this.cursorKeys.right.isDown) {
              this.tank_red_1.setVelocityX(gameSetting.tankSpeed); // set movement over axis x , velosity is directed to right
              this.tank_red_1.angle = -90;
            } else if (this.cursorKeys.up.isDown) {
              this.tank_red_1.setVelocityY(-gameSetting.tankSpeed); // set movement over axis y , velosity is directed to upward
              this.tank_red_1.angle = 180;
            } else if (this.cursorKeys.down.isDown) {
              this.tank_red_1.setVelocityY(gameSetting.tankSpeed); // set movement over axis x , velosity is directed down
              this.tank_red_1.angle = 0;
            }
          }
        }
