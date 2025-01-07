import {
  SovendusSettings,
  type SovendusSettingsType,
} from "../sovendus-plugins-commons/admin-frontend/sovendus-app-settings";
import React from "react";
import ReactDOM from "react-dom";

document.addEventListener("DOMContentLoaded", () => {
  const containerId = "sovendus-settings-container";
  const container = document.getElementById(containerId);
  if (!container) {
    console.error(`Container with id ${containerId} not found`);
    return;
  }
  const shadowRoot = container.attachShadow({ mode: "open" });
  const reactRoot = document.createElement("div");
  shadowRoot.appendChild(reactRoot);

  const handleSettingsUpdate = (updatedSettings: SovendusSettingsType) => {
    fetch(ajaxurl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        action: "save_sovendus_settings",
        settings: updatedSettings,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Settings saved successfully!");
        } else {
          alert("Failed to save settings.");
        }
      });
  };
  ReactDOM.render(
    React.createElement(SovendusSettings, {
      handleSettingsUpdate,
      settings: sovendusSettings.settings,
    }),
    reactRoot
  );
});
