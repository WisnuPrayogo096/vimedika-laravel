$(function () {
    const CLASSES = {
        active: {
            circle: "step-circle-active",
            line: "step-line-active",
        },
        inactive: {
            circle: "step-circle-inactive",
            line: "step-line-inactive",
        },
    };

    const stepperControllers = {};

    $(".stepper-container").each(function () {
        const $container = $(this);
        const stepperId = $container.attr("id");
        let currentStep = 1;

        function updateStepper(step) {
            $container.find("li.steps").each(function () {
                const stepIndex = $(this).data("step");
                const $circle = $(this).find("div");
                const isLastStep = $(this).is(":last-child");

                $circle
                    .removeClass(CLASSES.active.circle)
                    .addClass(CLASSES.inactive.circle);

                if (!isLastStep) {
                    $(this)
                        .removeClass(CLASSES.active.line)
                        .addClass(CLASSES.inactive.line);
                }

                if (stepIndex <= step) {
                    $circle
                        .removeClass(CLASSES.inactive.circle)
                        .addClass(CLASSES.active.circle);

                    if (stepIndex < step && !isLastStep) {
                        $(this)
                            .removeClass(CLASSES.inactive.line)
                            .addClass(CLASSES.active.line);
                    }
                }
            });

            $container.find(".step-content").addClass("hidden");
            $container
                .find(`.step-content[data-step="${step}"]`)
                .removeClass("hidden");
        }

        function validateStep(step, validationFuncName) {
            if (!validationFuncName) return true;

            if (typeof window[validationFuncName] !== "function") {
                console.error(`Function ${validationFuncName} is not defined`);
                return false;
            }

            try {
                return window[validationFuncName](step, $container);
            } catch (error) {
                console.error("Validation error:", error);
                return false;
            }
        }

        $container.on("click", ".stepper-indicators li.steps", function () {
            const clickedStep = $(this).data("step");
            const validationFunc = $(this).data("validate");

            if (!validationFunc) {
                currentStep = parseInt(clickedStep);
                updateStepper(currentStep);
                return;
            }

            const isValid = validateStep(currentStep, validationFunc);

            if (isValid && clickedStep) {
                currentStep = parseInt(clickedStep);
                updateStepper(currentStep);
            }
        });

        $container.on("click", ".next-step", function () {
            const nextStep = $(this).data("next-step");
            const validationFunc = $(this).data("validate");

            const isValid = validateStep(currentStep, validationFunc);

            if (isValid && nextStep) {
                currentStep = parseInt(nextStep);
                updateStepper(currentStep);
            }
        });

        $container.on("click", ".back-step", function () {
            const back = $(this).data("back-step");
            const validationFunc = $(this).data("validate");

            const isValid = validateStep(currentStep, validationFunc);

            if (isValid && back) {
                currentStep = parseInt(back);
                updateStepper(currentStep);
            }
        });

        stepperControllers[stepperId] = {
            reset: function () {
                currentStep = 1;
                updateStepper(currentStep);
            },
        };

        updateStepper(currentStep);
    });

    window.resetStep = function (stepperId) {
        if (stepperControllers[stepperId]) {
            stepperControllers[stepperId].reset();
        } else {
            console.warn(`Stepper with ID '${stepperId}' not found.`);
        }
    };
});
