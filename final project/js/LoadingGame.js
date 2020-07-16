class LoadingGame extends Phaser.Scene {
  constructor() {
    super("LoadGame");
  }

  preload() {
    try {
      this.load.image("background", "assets/background/background.png");
      this.load.spritesheet("tank_red_1", "assets/textures/tank_red_1.png", {
        frameWidth: 228,
        frameHeight: 268
      });
      this.load.spritesheet("tank_blue_1", "assets/textures/tank_blue_1.png", {
        frameWidth: 244,
        frameHeight: 329
      });
      this.load.spritesheet("red_barrel", "assets/textures/barrelRed_up.png", {
        frameWidth: 48,
        frameHeight: 48
      });
      this.load.spritesheet("pregrada", "assets/textures/pregrada.png", {
        frameWidth: 128,
        frameHeight: 128
      });

      this.load.spritesheet("animated_bullet", "assets/textures/animated_bullet.png", {
        frameWidth: 32,
        frameHeight: 48
      });

      this.anims.create({
        key: 'fire',
        frames: this.anims.generateFrameNames('animated_bullet', {
          start: 1,
          end: 17
        }),
        frameRate: 20,
        repeat: -1
      });


      this.load.audio("background_music", "assets/audio/BackGroundMusic.mp3");
    } catch (e) {
      console.log("Cannot load assets");
    }

  }

  create() {
    this.add.text(20, 20, "loading game...", {
      font: "30px Arial ",
      fill: "green"
    });

    alert("Game goes until 300points , each kill equals to 100 points");

    this.scene.start("PlayGame");

  }
}
