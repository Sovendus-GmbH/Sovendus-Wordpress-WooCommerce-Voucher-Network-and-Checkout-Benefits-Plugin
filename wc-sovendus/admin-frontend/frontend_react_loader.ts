import { SovendusSettings } from "../sovendus-plugins-commons/admin-frontend/sovendus-app-settings";
import React from "react";
import ReactDOM from "react-dom";
import { SovendusAppSettings } from "../sovendus-plugins-commons/settings/app-settings";

function loadSettingsUi(): void {
  const currentSettings = sovendusSettings.settings as SovendusAppSettings;
  const nonce = sovendusSettings.nonce as string;
  const saveUrl = sovendusSettings.ajaxurl as string;
  console.log("Save URL:", saveUrl);
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
    console.log("Payload:", {
      action: "save_sovendus_settings",
      security: nonce,
      settings: updatedSettings,
    });

    const formData = new URLSearchParams();
    formData.append("action", "save_sovendus_settings");
    formData.append("security", nonce);
    formData.append("settings", JSON.stringify(updatedSettings));

    try {
      const response = await fetch(saveUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: formData.toString(),
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
}

loadSettingsUi();
