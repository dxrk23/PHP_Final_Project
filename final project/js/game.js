var gameSetting = {
  tankSpeed: 250,
  maxRedBarrels: 4,
  newRound: false,
  redScore : 0,
  blueScore: 0
};

var config = {

  width: 1280,
  height: 720,
  backgroundColor: 0x000000,

  scene: [LoadingGame, LoadedGame],

  physics: {
    default: "arcade",
    arcade: {
      debug: false
    }
  }

};

// TODO:

var musicConfig = {
  mute: false,
  volume: 0.03,
  rate: 1,
  detune: 0,
  seek: 0,
  loop: true,
  delay: 0
};

var game = new Phaser.Game(config);
