import type { ReleaseConfig } from "sovendus-release-tool";

const releaseConfig: ReleaseConfig = {
  packages: [
    {
      directory: "./",
      version: "2.1.0",
      release: true,
      updateDeps: true,
      lintAndBuild: true,
      test: false,
      versionBumper: {
        jsVars: [
          // TODO handle the version string in wc-sovendus.php still needs to be done manually
          {
            filePath: "wc-sovendus/wc-sovendus.php",
            varName: "SOVENDUS_VERSION",
          },
        ],
      },

      releaseOptions: {
        foldersToScanAndBumpThisPackage: [
          // scan the whole dev env folder
          { folder: "../" },
        ],
      },
    },
  ],
};
export default releaseConfig;
