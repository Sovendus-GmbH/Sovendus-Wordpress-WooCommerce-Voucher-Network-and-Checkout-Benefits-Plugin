import React from "react";
import { createRoot } from "react-dom/client";
import { loggerError, loggerInfo } from "sovendus-integration-settings-ui";
import { SovendusBackendForm } from "sovendus-integration-settings-ui";
import type { SovendusAppSettings } from "sovendus-integration-types";

declare global {
  interface Window {
    sovendusSettings: {
      settings: SovendusAppSettings;
      ajaxurl: string;
      nonce: string;
    };
  }
}

function loadSettingsUi(): void {
  const currentSettings = window.sovendusSettings.settings;
  const nonce = window.sovendusSettings.nonce;
  const saveUrl = window.sovendusSettings.ajaxurl;
  loggerInfo("Loaded settings", currentSettings);
  const containerId = "sovendus-settings-container";
  const container = document.getElementById(containerId);
  if (!container) {
    loggerError(`Container with id ${containerId} not found`);
    return;
  }

  const handleSettingsUpdate = async (
    updatedSettings: SovendusAppSettings,
  ): Promise<SovendusAppSettings> => {
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
        loggerInfo("Settings saved successfully", updatedSettings);
        return updatedSettings;
      } else {
        const errorText = await response.text();
        throw new Error(errorText);
      }
    } catch (error) {
      loggerError("Save failed:", error);
      throw error;
    }
  };

  const root = createRoot(container);
  root.render(
    React.createElement(SovendusBackendForm, {
      currentStoredSettings: currentSettings,
      saveSettings: handleSettingsUpdate,
      callSaveOnLoad: false,
    }),
  );
}

loadSettingsUi();
