// import("tailwindcss").Config;
export default {
  darkMode: ["class"],
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        // IRANSans: ["IRANSans"],
      },
      colors: {
        "light-gray" : "rgba(var(--mh-light-gray-color),var(--mh-bg-opacity));",
        "light-soft-gray" : "rgba(var(--mh-light-gray-color),var(--mh-bg-opacity-soft));",
        "dark-gray" : "rgba(var(--mh-dark-gray-color),var(--mh-bg-opacity));",
        "dark-soft-gray" : "rgba(var(--mh-dark-gray-color),var(--mh-bg-opacity-soft));",
        "light-slate" : "rgba(var(--mh-light-slate-color),var(--mh-bg-opacity));",
        "light-soft-slate" : "rgba(var(--mh-light-slate-color),var(--mh-bg-opacity-soft));",
        "dark-slate" : "rgba(var(--mh-dark-slate-color),var(--mh-bg-opacity));",
        "dark-soft-slate" : "rgba(var(--mh-dark-slate-color),var(--mh-bg-opacity-soft));",
        "typograph" : {
          "header": "rgb(var(--mh-typograph-header-color))",
          "sub-header": "rgb(var(--mh-typograph-sub-header-color))",
        },
        "card": "rgb(var(--mh-card-color))",
        primary: "rgb(var(--mh-primary-color))",
        success: "rgb(var(--mh-success-color))",
        info: "rgb(var(--mh-info-color))",
        warning: "rgb(var(--mh-warn-color))",
        error: "rgb(var(--mh-error-color))",
        transparent: "transparent",
        current: "currentColor",
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
