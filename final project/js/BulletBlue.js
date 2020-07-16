class BulletBlue extends Phaser.GameObjects.Sprite {
  constructor(scene) {

    // TODO: Заменить пулю на шар

    if (scene.tank_blue_1.angle == 0) {
      var x = scene.tank_blue_1.x;
      var y = scene.tank_blue_1.y + 40;
    } else if (scene.tank_blue_1.angle == 90) {
      var x = scene.tank_blue_1.x - 40;
      var y = scene.tank_blue_1.y;
    } else if (scene.tank_blue_1.angle == -90) {
      var x = scene.tank_blue_1.x + 40;
      var y = scene.tank_blue_1.y;
    } else {
      var x = scene.tank_blue_1.x;
      var y = scene.tank_blue_1.y - 40;
    }

    super(scene, x, y, "animated_bullet");

    scene.add.existing(this);

    scene.physics.world.enableBody(this);
    this.body.setVelocityY(-250);

    if (scene.tank_blue_1.angle == 180) {
      this.body.setVelocityY(-250);
    }
    if (scene.tank_blue_1.angle == 0) {
      this.body.setVelocityY(250);
            this.angle -= 180;
    }
    if (scene.tank_blue_1.angle == 90) {
      this.body.setVelocityX(-250);
      this.body.setVelocityY(0);
      this.angle -= 90;
    }
    if (scene.tank_blue_1.angle == -90) {
      this.body.setVelocityX(250);
      this.body.setVelocityY(0);
      this.angle += 90
    }

    scene.utilities.add(this);
  }

  update() {
    if (this.y < 0 && this.y > 730) {
      this.destroy();
    }
  }
}
