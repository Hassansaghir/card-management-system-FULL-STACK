package com.fintech.cms.service;

import org.json.JSONObject;
import org.springframework.stereotype.Service;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

@Service
public class ExternalTranslationService {

    private static final String API_URL = "https://translateai.p.rapidapi.com/google/translate/text";
    private static final String API_KEY = "f8a2c61f86mshd0b7849d47fb0a3p1439aajsndc942e28fea2";

    public String translateText(String inputText, String targetLang) {
        try {
            // Build JSON body
            String jsonBody = "{"
                    + "\"origin_language\":\"auto\","
                    + "\"target_language\":\"" + targetLang + "\","
                    + "\"words_not_to_translate\":\"Para; Experimenta\","
                    + "\"input_text\":\"" + inputText + "\""
                    + "}";

            // Build HTTP request
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(API_URL))
                    .header("x-rapidapi-key", API_KEY)
                    .header("x-rapidapi-host", "translateai.p.rapidapi.com")
                    .header("Content-Type", "application/json")
                    .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
                    .build();

            // Send request
            HttpResponse<String> response = HttpClient.newHttpClient()
                    .send(request, HttpResponse.BodyHandlers.ofString());

            // Parse outer JSON
            JSONObject outer = new JSONObject(response.body());

            if (outer.has("message")) {
                String innerMessage = outer.getString("message").trim();
                String cleanMessage;

                // Check if the message is JSON
                if (innerMessage.startsWith("{")) {
                    JSONObject inner = new JSONObject(innerMessage);
                    cleanMessage = inner.has("translation") ? inner.getString("translation") : innerMessage;
                } else {
                    cleanMessage = innerMessage; // already plain text
                }

                // Replace outer "message" with clean translation
                outer.put("message", cleanMessage);
            }

            return outer.get("translation").toString();

        } catch (Exception e) {
            System.err.println("Translation failed: " + e.getMessage());
        }

        // fallback
        return "{ \"status\": \"error\", \"message\": \"" + inputText + "\" }";
    }
}
