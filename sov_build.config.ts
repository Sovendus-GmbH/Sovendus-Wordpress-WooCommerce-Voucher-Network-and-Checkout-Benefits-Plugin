import type { BuildConfig } from "sovendus-builder";

const buildConfig: BuildConfig = {
  foldersToClean: ["wc-sovendus/dist"],
  filesToCompile: [
    {
      input: "wc-sovendus/admin-frontend/frontend_react_loader.ts",
      output: "wc-sovendus/dist/frontend_react_loader.js",
      options: { type: "react-tailwind" },
    },
    {
      input:
        "node_modules/sovendus-integration-scripts/src/scripts/landing-page/sovendus-page.ts",
      output: "wc-sovendus/dist/sovendus-page.js",
      options: { type: "vanilla" },
    },
    {
      input:
        "node_modules/sovendus-integration-scripts/src/scripts/thankyou-page/thankyou-page.ts",
      output: "wc-sovendus/dist/thankyou-page.js",
      options: { type: "vanilla" },
    },
  ],
  filesOrFoldersToCopy: [
    {
      input:
        "node_modules/sovendus-integration-settings-ui/dist/logos/sovendus-logo-white.png",
      output: "wc-sovendus/dist/sovendus-logo-white.png",
    },
  ],
  foldersToZip: [
    {
      input: "wc-sovendus",
      output: "releases/%NAME%_%VERSION%.zip",
    },
    {
      input: "wc-sovendus",
      output: "releases/%NAME%_latest.zip",
    },
  ],
};

export default buildConfig;
