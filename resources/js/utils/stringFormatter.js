// src/utils/stringFormatter.js

/**
 * Capitalizes the first letter of each word in a string.
 * Example: "john doe" => "John Doe"
 * @param {string} str
 * @returns {string}
 */
export const capitalize = (str) => {
  if (!str) return '';
  return str
    .toLowerCase()
    .split(' ')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
};
