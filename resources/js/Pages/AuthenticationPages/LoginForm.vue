<script setup>
import { ref } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

import FeaturesComp from "../../Components/FeaturesComp.vue";
import ContactComp from "../../Components/ContactComp.vue";
import FooterComp from "../../Components/FooterComp.vue";

import { successToast, errorToast } from "@/utils/toast";

// Reactive state
const email = ref("");
const loading = ref(false);

// Helper: Basic email format validation
const isValidEmail = (value) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(value);
};

// Send OTP Handler
const sendOTP = async () => {
    const trimmedEmail = email.value.trim();

    // Validation Checks
    if (!trimmedEmail) {
        errorToast("Please enter your email.");
        return;
    }

    if (!isValidEmail(trimmedEmail)) {
        errorToast("Please enter a valid email address.");
        return;
    }

    loading.value = true;

    try {
        const response = await axios.post("/api/auth/login", {
            email: trimmedEmail,
        });

        const { data } = response;

        if (data?.status === true) {
            localStorage.setItem("email", trimmedEmail);
            successToast(data.data);

            setTimeout(() => {
                router.visit("/OtpForm");
            }, 1000);
        } else {
            errorToast(data?.data || "Something went wrong. Please try again.");
        }
    } catch (error) {
        let message = "An error occurred. Please try again.";
        if (error.response?.data?.data) {
            message = error.response.data.data;
        } else if (error.message) {
            message = error.message;
        }
        errorToast(message);
    } finally {
        loading.value = false;
    }
};

// Navigation handlers
const goBack = () => window.history.back();
const goHome = () => router.visit("/");
</script>

<template>
    <div
        class="d-flex align-items-center justify-content-center"
        style="
            min-height: 100vh;
            background: linear-gradient(to right, #00c6ff, #0072ff);
        "
    >
        <div class="w-100" style="max-width: 400px">
            <!-- Back Button -->
            <button
                @click.prevent="goBack"
                :disabled="loading"
                class="btn btn-outline-light mb-3"
            >
                <i class="bi bi-arrow-left"></i> Back
            </button>
            <!-- Back To Home Button -->
            <button
                @click.prevent="goHome"
                :disabled="loading"
                class="btn mx-3 btn-outline-light mb-3"
            >
                <i class="bi bi-house-door-fill"></i> Home
            </button>

            <!-- Login Card -->
            <div class="card p-4">
                <h3 class="text-center mb-4">Login</h3>
                <form @submit.prevent="sendOTP">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <input
                                v-model="email"
                                type="email"
                                class="form-control"
                                id="email"
                                placeholder="Enter your email"
                                :readonly="loading"
                            />
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                        :disabled="loading"
                    >
                        <span
                            v-if="loading"
                            class="spinner-border spinner-border-sm"
                        ></span>
                        <span v-else>
                            <i class="bi bi-send-fill me-1"></i> Send OTP
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Features -->
    <features-comp />
    <!-- Contact -->
    <contact-comp />
    <!-- Footer -->
    <footer-comp />
</template>

<style scoped>
/* Additional styling if needed */
</style>
