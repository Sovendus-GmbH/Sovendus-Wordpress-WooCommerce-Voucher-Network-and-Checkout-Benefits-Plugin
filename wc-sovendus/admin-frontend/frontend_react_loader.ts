import { SovendusSettings } from "../sovendus-plugins-commons/admin-frontend/sovendus-app-settings";
import React from "react";
import ReactDOM from "react-dom";
import type { SovendusFormDataType } from "../sovendus-plugins-commons/admin-frontend/sovendus-app-types";

document.addEventListener("DOMContentLoaded", () => {
  const currentSettings = sovendusSettings.settings as SovendusFormDataType;
  const saveUrl = ajaxurl as string;
  const containerId = "sovendus-settings-container";
  const container = document.getElementById(containerId);
  if (!container) {
    console.error(`Container with id ${containerId} not found`);
    return;
  }
  const shadowRoot = container.attachShadow({ mode: "open" });
  const reactRoot = document.createElement("div");
  shadowRoot.appendChild(reactRoot);

  const handleSettingsUpdate = async (
    updatedSettings: SovendusFormDataType
  ) => {
    const response = await fetch(saveUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "save_sovendus_settings",
        settings: updatedSettings,
      }),
    });
    const data = await response.json();

    if (data.success) {
      alert("Settings saved successfully!");
      return updatedSettings;
    } else {
      alert("Failed to save settings.");
      return updatedSettings;
    }
  };
  ReactDOM.render(
    React.createElement(SovendusSettings, {
      saveSettings: handleSettingsUpdate,
      currentStoredSettings: currentSettings,
    }),
    reactRoot
  );
});
