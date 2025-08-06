$(document).ready(function () {
    // nice select

    // $("select").niceSelect();
    $('.marquee-text').marquee();
    // progress bar

    $(".progress-bar").ProgressBar();

    // jquery tab

    $("#comments--tab").skeletabs({
        selectEvent: "click",
        transitionDuration: 1000,
        breakpoint: 0,
    });
    $(".cart-wishlist-tab").skeletabs({
        selectEvent: "click",
        transitionDuration: 500,
        breakpoint: 0,
    });
    $(".reviewed--images--gallery").skeletabs({
        selectEvent: "click",
        transitionDuration: 500,
        breakpoint: 0,
    });




    //  redirect to product page in mobile
    const redirect = () => {
        const btn = document.querySelector(".shop-all-arrow.mobile");
        let counter = 0;

        // Check if the device is mobile (screen width <= 768px)
        if (window.innerWidth <= 768) {
            if (btn) {
                btn.addEventListener("click", () => {
                    counter++;
                    if (counter === 2) {
                        window.location.href = "/collections/all";
                        counter = 0;
                    }
                });
            }
        }
    };

    redirect();


    // home sidebar toggle
    function toggleActive(buttonSelector, wrapperSelector, closeButtonSelector) {
        const wrappers = document.querySelector(wrapperSelector);
        const buttons = document.querySelector(buttonSelector);

        console.log(wrappers);
        console.log(buttons);

        const closeButtons = wrappers
            ? wrappers.querySelector(closeButtonSelector)
            : null;
        const contentArea = wrappers
            ? wrappers.querySelector("[data-inner-content]")
            : null;

        // Check if any element is null
        if (
            !wrappers ||
            !buttons ||
            (closeButtonSelector && closeButtons === null)
        ) {
            console.warn("One or more required elements not found.");
            return; // Exit the function if any element is missing
        }

        // Add event listener for the toggle button
        buttons.addEventListener("click", () => {
            wrappers.classList.add("active");
            buttons.style.visibility = "hidden";
        });

        // Add event listener for close button if it exists
        if (closeButtons) {
            closeButtons.addEventListener("click", (event) => {
                event.stopPropagation();
                closeWrapper();
            });
        }

        // Function to close the wrapper
        function closeWrapper() {
            wrappers.classList.remove("active");
            buttons.style.visibility = "visible";
        }

        // Add event listener to close when clicking outside the content area
        if (contentArea) {
            wrappers.addEventListener("click", (event) => {
                if (!contentArea.contains(event.target)) {
                    closeWrapper();
                }
            });
        }
    }

    // Call the function
    toggleActive(".hamburger", ".backdrop-container--home", ".close--navigation");

    // zoom image
    function magnifier() {
        // Check if the device is not mobile (can be adjusted based on your needs)
        if ($(window).width() > 575) {  // You can adjust 768px based on your desired breakpoint
            $("#zoom-image").elevateZoom({
                zoomType: "lens", // Use lens type
                lensShape: "square", // Optional: shape of the lens (can be "round" or "square")
                lensSize: 200, // Set the lens size (300px)
                zoomWindowWidth: 200, // Width of the zoom window
                zoomWindowHeight: 200, // Height of the zoom window
                scrollZoom: true, // Enable scroll zoom
                zoomLevel: 1, // Decrease the zoom level (1 is 100%, 2 is 200%, etc.)
            });
        }
    }

    magnifier();


    // product preview

    function product_preview(thumbsWrapper, previewWrapper) {
        const thumbsContainer = document.querySelector(thumbsWrapper);
        const previewContainer = document.querySelector(previewWrapper + " img");

        // Check if the thumbnails container and preview image exist
        if (!thumbsContainer || !previewContainer) {
            console.warn("Thumbnail container or preview image not found.");
            return; // Exit if elements are not found
        }

        const thumbItems = thumbsContainer.querySelectorAll(".thumb--item");

        thumbItems.forEach((thumbItem) => {
            thumbItem.addEventListener("click", () => {
                // Remove 'active' class from all thumb items
                thumbItems.forEach((item) => item.classList.remove("active"));

                // Add 'active' class to the clicked thumb item
                thumbItem.classList.add("active");

                // Update the preview image source based on the clicked thumbnail's image
                const thumbImg = thumbItem.querySelector("img");
                const previewSrc = thumbImg ? thumbImg.getAttribute("src") : null; // Get the image src safely

                if (previewSrc) {
                    previewContainer.src = previewSrc; // Update the preview image src
                    magnifier();
                }
            });
        });
    }

    // Call the function
    product_preview(".thumb-image--box", ".product-preview--container");

    // custom modal

    function customModal(wrapper, show_buttons, close_buttons) {
        const Wrapper = document.querySelector(wrapper);
        const ShowButtons = document.querySelectorAll(show_buttons);
        const CloseButtons = document.querySelectorAll(close_buttons);

        // Check if the wrapper exists
        if (Wrapper) {
            // Show the modal for each open button
            ShowButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    Wrapper.classList.add("active");
                    document.body.classList.add("no-scroll"); // Disable body scroll
                });
            });

            // Close the modal for each close button
            CloseButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    Wrapper.classList.remove("active");
                    document.body.classList.remove("no-scroll"); // Re-enable body scroll
                });
            });

            // Close modal when clicking outside of the wrapper
            Wrapper.addEventListener("click", (event) => {
                if (event.target === Wrapper) {
                    Wrapper.classList.remove("active");
                    document.body.classList.remove("no-scroll"); // Re-enable body scroll
                }
            });
        } else {
            console.warn("Required wrapper element not found:", Wrapper);
        }
    }

    // Initialize the modal functionality

    // for filter modal
    customModal(".backdrop-container--filter", ".filter--btn", ".filter-close");

    // for cart sidebar

    customModal(".cart-items--sidebar", ".show-cart-item", ".cart-items--close");

    // set naming format for customer review
    const setNameFormatModal = (button, modal) => {
        const btn = document.querySelector(button);
        const container = document.querySelector(modal);
        if (btn && container) {
            // Toggle modal on button click
            btn.addEventListener("click", (event) => {
                event.stopPropagation();
                event.preventDefault();
                container.classList.toggle("active");
            });

            // Close modal when clicking outside of it
            document.addEventListener("click", (event) => {
                if (
                    container.classList.contains("active") &&
                    !container.contains(event.target) &&
                    !btn.contains(event.target)
                ) {
                    container.classList.remove("active");
                }
            });

            // Prevent modal close when clicking inside the modal
            container.addEventListener("click", (event) => {
                event.stopPropagation();
            });
        }
    };

    // Initialize the function
    setNameFormatModal(".name--format--wrapper", ".name--formats--container");

    // set naming format for user comment

    const setNameFormat = (optionsWrapper) => {
        const optionsContainer = document.querySelector(optionsWrapper);
        const display =
            optionsContainer?.parentNode.querySelector(".name-selected");
        const options = optionsContainer?.querySelectorAll("input");
        if (display && options && optionsContainer) {
            options.forEach((options) => {
                options.addEventListener("change", (event) => {
                    const selectedValue = event.target.value;
                    display.textContent = `(${selectedValue})`;
                });
            });
        }
    };
    setNameFormat(".name--formats--container");

    // character counter
    const initCharacterCounter = (inputSelector) => {
        const inputElement = document.querySelector(inputSelector);
        if (!inputElement) return; // Early exit if the input element doesn't exist

        const wrapperElement = inputElement.closest(
            ".common--review--input--wrapper"
        );
        if (!wrapperElement) return; // Early exit if the wrapper element doesn't exist

        const counterElement = wrapperElement.querySelector(".counter"); // Finds the counter in the same wrapper
        if (!counterElement) return; // Early exit if the counter element doesn't exist

        const maxLength = inputElement.getAttribute("maxlength") || 0; // Default to 0 if not set

        // Set initial counter value
        const updateCounter = () => {
            const currentLength = inputElement.value.length;
            counterElement.textContent = `${currentLength}/${maxLength}`;
        };

        // Update the counter on input event
        inputElement.addEventListener("input", updateCounter);

        // Initialize the counter on page load
        updateCounter();
    };

    // Initialize for both input and textarea fields
    initCharacterCounter("#title"); // For review title
    initCharacterCounter("#details"); // For product review

    // document.querySelector(".review-submit--btn").addEventListener(("click", (e)=>{
    //   e.preventDefault();
    // }))

    // added to wishlist

    // const addedWishlist = () => {
    //   const wishlistBtn = document.querySelectorAll(".wishlist--icon");
    //   wishlistBtn.forEach((btn) => {
    //     btn.addEventListener("click", () => {
    //       btn.classList.toggle("added");
    //     });
    //   });
    // };
    // addedWishlist();

    // toggle password field

    const togglePassword = (btn) => {
        const buttons = document.querySelectorAll(btn);
        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                // Find the input field associated with the button
                const input = button.closest(".form-floating").querySelector("input");
                // Toggle the input type
                input.type = input.type === "password" ? "text" : "password";
                // Optionally, change the button text (if desired)
                button.textContent = button.textContent === "Show" ? "Hide" : "Show";
            });
        });
    };

    togglePassword(".show--password--btn");

    const toggleSideBar = (sidebar, open_btn, close_btn, page_wrapper) => {
        const openButton = document.querySelector(open_btn);
        const sideBar = document.querySelector(sidebar);
        const closeButton = document.querySelector(close_btn);
        const pageWrapper = document.querySelector(page_wrapper);

        // Check if elements exist
        if (!openButton || !sideBar || !closeButton || !pageWrapper) {
            console.error("One or more elements not found");
            return;
        }

        // Function to toggle the sidebar and apply blur
        const toggleSidebar = () => {
            sideBar.classList.toggle("active"); // Toggle the active class
            pageWrapper.classList.toggle("blurred"); // Toggle blur on the page wrapper
        };

        // Event listeners for toggling the sidebar
        openButton.addEventListener("click", toggleSidebar);
        closeButton.addEventListener("click", toggleSidebar);

        // Close the sidebar when clicking outside of it
        document.addEventListener("click", (event) => {
            if (
                !sideBar.contains(event.target) &&
                !openButton.contains(event.target)
            ) {
                if (sideBar.classList.contains("active")) {
                    toggleSidebar();
                }
            }
        });
    };

    // Initialize the sidebar toggle
    toggleSideBar(
        ".common-side--bar",
        "#open--sidebar",
        ".close---btn--sidebar",
        ".main-display"
    );

    // confetti config

    const confettiInit = () => {
        var canvas = document.getElementById("confetti-canvas");
        if (canvas) {
            canvas.confetti =
                canvas.confetti || confetti.create(canvas, { resize: true });
            var count = 200;
            var defaults = {
                origin: { y: 0.6 }, // Adjust the origin to be higher
            };

            function fire(particleRatio, opts) {
                canvas.confetti({
                    ...defaults,
                    ...opts,
                    particleCount: Math.floor(count * particleRatio),
                    duration: 4000,
                });
            }
            let isConfettiTriggered = false;
            function triggerConfetti() {
                if ($("#success-modal").hasClass("show") && !isConfettiTriggered) {
                    isConfettiTriggered = true; // Prevent multiple triggers
                    fire(0.25, { spread: 26, startVelocity: 55 });
                    fire(0.2, { spread: 60 });
                    fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
                    fire(0.1, {
                        spread: 120,
                        startVelocity: 25,
                        decay: 0.92,
                        scalar: 1.2,
                    });
                    fire(0.1, { spread: 120, startVelocity: 45 });

                    // Reset flag after some time
                    setTimeout(() => {
                        isConfettiTriggered = false;
                    }, 5000); // Adjust duration as needed
                } else {
                    console.warn(
                        "Modal is not shown or confetti already triggered; cannot trigger confetti."
                    );
                }
            }

            $("#success-modal").on("shown.bs.modal", function () {
                triggerConfetti();
            });
        }
    };

    confettiInit();

    function handleImageUpload(
        inputElement,
        imagesWrapper,
        progressBar,
        maxImages
    ) {
        // Store the uploaded files in an array to track them
        let uploadedImages = [];

        // Get the remaining image count element and the "add--image--box"
        const remainingImageCount = document.querySelector(".remaining--image");
        const addImageBox = document.querySelector(".add--image--box");

        // Function to update the remaining image count dynamically
        function updateImageCount() {
            if (remainingImageCount && addImageBox) {
                const remainingCount = maxImages - uploadedImages.length;
                remainingImageCount.textContent = `(${uploadedImages.length}/${maxImages})`;

                // Hide the "add--image--box" if the max limit is reached
                if (uploadedImages.length >= maxImages) {
                    addImageBox.style.display = "none"; // Hide the add image box
                } else {
                    addImageBox.style.display = "flex"; // Show it if less than max images
                }
            }
        }

        // Update the count at the start
        updateImageCount();

        if (inputElement && imagesWrapper && progressBar) {
            inputElement.addEventListener("change", function () {
                const files = Array.from(inputElement.files);
                let totalFiles = files.length;
                let filesUploaded = 0;

                // Check if uploading exceeds the max limit
                if (uploadedImages.length + totalFiles > maxImages) {
                    totalFiles = maxImages - uploadedImages.length; // Limit files to upload
                    alert(`You can only upload up to ${maxImages} images.`);
                }

                // Reset the global progress bar at the start
                progressBar.style.width = "0%";
                progressBar.style.display = "block"; // Show the global progress bar

                files.slice(0, totalFiles).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        // Create a new image box for each uploaded image
                        const imageBox = document.createElement("div");
                        imageBox.classList.add("common--image--box");
                        imageBox.style.backgroundImage = `url(${e.target.result})`;

                        // Add spinner
                        const spinner = document.createElement("div");
                        spinner.classList.add("spin--loader");
                        imageBox.appendChild(spinner);

                        // Add remove button
                        const removeBtn = document.createElement("span");
                        removeBtn.classList.add("remove--image--btn");

                        // Code from Backend
                        let imagePath = window.appUrl + '/frontend/assets/images/remove_image_btn.svg';
                        removeBtn.innerHTML = `<img src="${imagePath}" alt="Remove Image">`;


                        // Remove image functionality
                        removeBtn.addEventListener("click", function () {
                            imagesWrapper.removeChild(imageBox); // Remove the image box from the DOM
                            uploadedImages = uploadedImages.filter((img) => img !== file); // Remove from array
                            updateImageCount(); // Update image count after removal
                        });

                        imageBox.appendChild(removeBtn); // Add remove button to the image box
                        imagesWrapper.insertBefore(imageBox, addImageBox);
                        uploadedImages.push(file); // Store the image in the uploadedImages array

                        // Update the image count after adding a new image
                        updateImageCount();

                        // Simulate image loading progress
                        let progress = 0;
                        const interval = setInterval(() => {
                            progress += 10;

                            // Update spinner progress
                            spinner.style.setProperty("--progress", `${progress}%`);

                            // Update global progress bar as each image progresses
                            const overallProgress =
                                ((filesUploaded + progress / 100) / totalFiles) * 100;
                            progressBar.style.width = `${overallProgress}%`;

                            if (progress >= 100) {
                                clearInterval(interval);
                                spinner.style.display = "none"; // Hide spinner after loading
                                filesUploaded++;

                                // Hide global progress bar when all images are uploaded
                                if (filesUploaded === totalFiles) {
                                    setTimeout(() => {
                                        progressBar.style.display = "none"; // Hide the global bar after all images are uploaded
                                    }, 500); // Adding a small delay before hiding the bar
                                }
                            }
                        }, 300); // Simulate progress speed
                    };
                    reader.readAsDataURL(file);
                });
            });
        } else {
            console.warn("Input element, images wrapper, or progress bar not found.");
        }
    }
    const reviewImageInput = document.getElementById("review-image");
    const uploadedImagesWrapper = document.querySelector(
        ".uploaded--images--wrapper"
    );
    const uploadStateBar = document.querySelector(".upload--state--bar");

    // Only call handleImageUpload if elements exist
    if (reviewImageInput && uploadedImagesWrapper && uploadStateBar) {
        handleImageUpload(
            reviewImageInput,
            uploadedImagesWrapper,
            uploadStateBar,
            5
        );
    } else {
        console.warn("Image upload elements not found on this page.");
    }

    function setupToggle(toggleButtonSelector, containerSelector) {
        const toggleButton = document.querySelector(toggleButtonSelector);
        const cartItemsContainer = document.querySelector(containerSelector);
        const showHideText = toggleButton
            ? toggleButton.querySelector(".show---icon--container span")
            : null;
        const arrowIcon = toggleButton
            ? toggleButton.querySelector(".show--arrow--down--icon")
            : null;

        // Check if all elements were found
        if (toggleButton && cartItemsContainer && showHideText && arrowIcon) {
            toggleButton.addEventListener("click", function () {
                cartItemsContainer.classList.toggle("hide");

                // Toggle text and icon rotation
                if (cartItemsContainer.classList.contains("hide")) {
                    showHideText.textContent = "Show";
                    arrowIcon.style.transform = "rotate(0deg)"; // Reset rotation
                } else {
                    showHideText.textContent = "Hide";
                    arrowIcon.style.transform = "rotate(180deg)"; // Rotate arrow
                }
            });
        } else {
            console.warn(
                `One or more elements not found: ${toggleButtonSelector}, ${containerSelector}`
            );
        }
    }

    // Initialize the toggle functionality
    setupToggle(
        ".toggle--order--summery--btn",
        ".cart--items--container--checkout"
    );

    // preloader

    $(window).on("load", function () {
        $(".preloader").fadeOut("slow");
    });

    // Fallback timeout
    setTimeout(function () {
        $(".preloader").fadeOut("slow");
    }, 5000); // 5 seconds

    // Function to initialize the syotimer with the target date
    function initializeVacationTimer(targetDate) {
        // Check if the #timer--box exists in the DOM
        if ($("#timer--box").length) {
            // Initialize syotimer with the target date
            $("#timer--box").syotimer({
                date: targetDate,
                periodic: false,
                layout: "dhms",
                afterDeadline: function () {
                    $("#timer--box").text("We are back from vacation!");
                },
            });
        } else {
            console.error("#timer--box element not found!");
        }
    }

    // countdown timer function

    // Get the current date
    let currentDate = new Date();
    let targetDate = new Date(currentDate);
    targetDate.setDate(currentDate.getDate() + 20);
    let timeElement = document.getElementById("timer--box");
    let endTime = timeElement.getAttribute("data-end-time"); // Full end date-time string

    // If your endTime is not in EDT, adjust it accordingly
// Example: "2024-11-29T00:00:00-04:00" for EDT
    let targetTimeDate = new Date(endTime);

// Check if the endTime is in EDT by converting it to UTC and then back to EDT
    if (targetTimeDate.getTimezoneOffset() === -240) { // -240 is the offset for EDT
        console.log("End Date for Countdown in EDT:", targetTimeDate);
    } else {
        console.log("End Date is not in EDT. Adjusting...");
        targetTimeDate.setHours(targetTimeDate.getHours() - (targetTimeDate.getTimezoneOffset() / 60) + 4); // Adjust to EDT
    }

    $("#timer--box").syotimer({
        date: targetTimeDate,
        periodic: false,
        layout: "dhms",
        headTitle: "",
        afterDeadline: function () {
            $("#timer--box").text("Time is up!");
        },
    });
});
