import { SovendusSettings } from "../sovendus-plugins-commons/admin-frontend/sovendus-app-settings";
import React from "react";
import ReactDOM from "react-dom";
import { SovendusAppSettings } from "../sovendus-plugins-commons/settings/app-settings";

document.addEventListener("DOMContentLoaded", () => {
  const currentSettings = sovendusSettings.settings as SovendusAppSettings;
  const nonce = sovendusSettings.nonce as string;
  // TODO
  // const saveUrl = ajaxurl as string;
  const saveUrl = "/wp-json/sovendus/v1/save-settings";
  console.log("Current settings:", currentSettings);
  const containerId = "sovendus-settings-container";
  const container = document.getElementById(containerId);
  if (!container) {
    console.error(`Container with id ${containerId} not found`);
    return;
  }

  const handleSettingsUpdate = async (
    updatedSettings: SovendusAppSettings
  ): Promise<SovendusAppSettings> => {
    console.log("Attempting to save settings...");

    try {
      const response = await fetch(saveUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-WP-Nonce": nonce,
        },
        body: JSON.stringify({ settings: updatedSettings }),
      });

      if (response.ok) {
        console.log("Settings saved successfully");
        return updatedSettings;
      } else {
        const errorText = await response.text();
        throw new Error(errorText);
      }
    } catch (error) {
      console.error("Save failed:", error);
      throw error;
    }
  };

  ReactDOM.render(
    React.createElement(SovendusSettings, {
      saveSettings: handleSettingsUpdate,
      currentStoredSettings: currentSettings,
    }),
    container
  );
});
