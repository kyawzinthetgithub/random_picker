/*
	Slot Machine
*/

$(document).ready(function () {
    var customer = [];
    var product = [];

    var cus_id = [];
    var prod_id = [];
    $.ajax({
        url: "getCustomer",
        method: "GET",
        success: function (data) {
            // console.log(data);
            $.each(data.customer, function (i, v) {
                var name = v.name;
                var id = v.id;

                customer.push(name);
                cus_id.push(id);
            });

            $.each(data.product, function (i, v) {
                var name = v.name;
                var id = v.id;

                product.push(name);
                prod_id.push(id);
            });

            initializeSlotMachine();
        },
    });
    function initializeSlotMachine() {
        var sm = (function (undefined) {
            var tMax = 4000, // animation time, ms
                height = 210,
                speeds = [],
                r = [],
                reels = [customer, product],
                ids = [cus_id, prod_id],
                $reels,
                $msg,
                start;
            // console.log(reels);
            // console.log(ids);

            function saveWinner() {
                var cus_id = $("#cus_id").val();
                var prod_id = $("#prod_id").val();

                console.log(cus_id, prod_id);
                $.ajax({
                    url: "uploadWinner",
                    method: "POST",
                    data: { cus_id, prod_id },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function () {
                        // console.log("Successfully Saved Winner");
                        location.reload();
                    },
                });
            }
            function init() {
                $reels = $(".reel").each(function (i, el) {
                    el.innerHTML =
                        "<div><p>" +
                        reels[i].join("</p><p>") +
                        "</p></div><div><p>" +
                        reels[i].join("</p><p>") +
                        "</p></div><div><p>" +
                        reels[i].join("</p><p>") +
                        "</p></div><div><p>" +
                        reels[i].join("</p><p>") +
                        "</p></div>"
                        "<div><p>" +
                        reels[i].join("</p><p>") +
                        "</p></div><div><p>" +
                        reels[i].join("</p><p>") +
                        "</p></div>";
                });

                $msg = $(".msg");

                $("#startSlot").click(action);

                if (reels[1].length < 1 || reels[0].length < 1) {
                    $("#startSlot").attr("disabled", "true");
                    $("#startSlot").html(`<p>No More</p>`);
                    $("#startSlot").css({
                        color: "silver",
                        "font-size": "26px",
                    });
                }
            }

            function action(event) {
                event.preventDefault();

                if (start !== undefined) return;
                spinning = true;
                for (var i = 0; i < 2; ++i) {
                    speeds[i] = Math.random() + 2;
                    r[i] = (((Math.random() * 3) | 0) * height) / 3;

                    // console.log(r)
                    // console.log(speeds);
                }
                $msg.html("Spinning...");
                $("#startSlot").toggleClass("hidden");
                $(".TwoColorBtn").css({
                    opacity: 0,
                });
                $("#startSlot").text("SPINNING...");
                //  check();
                animate();
            }
            window.addEventListener("beforeunload", function (e) {
                if (spinning) {
                    var confirmationMessage =
                        "Leaving this page will stop the spinning animation. Are you sure you want to leave?";
                    (e || window.e).returnValue = confirmationMessage; // Standard for most browsers
                    return confirmationMessage; // For some older browsers
                }
            });

            function animate(now) {
                if (!start) start = now;
                var t = now - start || 0;

                for (var i = 0; i < 2; ++i)
                    $reels[i].scrollTop =
                        ((speeds[i] / tMax / 2) * (tMax - t) * (tMax - t) +
                            r[i]) %
                            height |
                        0;

                if (t < tMax) requestAnimationFrame(animate);
                else {
                    start = undefined;
                    check();
                }
            }

            function check() {
                $msg.html(
                    reels[0][(r[0] / 70 + 1) % reels[0].length | 0] +
                        " won!" +
                        reels[1][(r[1] / 70 + 1) % reels[1].length | 0]
                );

                // winner effect

                let W = window.innerWidth;
                let H = window.innerHeight;
                const canvas = document.getElementById("canvas");
                const context = canvas.getContext("2d");
                const maxConfettis = 150;
                const particles = [];

                const possibleColors = [
                    "DodgerBlue",
                    "OliveDrab",
                    "Gold",
                    "Pink",
                    "SlateBlue",
                    "LightBlue",
                    "Gold",
                    "Violet",
                    "PaleGreen",
                    "SteelBlue",
                    "SandyBrown",
                    "Chocolate",
                    "Crimson",
                ];

                function randomFromTo(from, to) {
                    return Math.floor(Math.random() * (to - from + 1) + from);
                }

                function confettiParticle() {
                    this.x = Math.random() * W; // x
                    this.y = Math.random() * H - H; // y
                    this.r = randomFromTo(11, 33); // radius
                    this.d = Math.random() * maxConfettis + 11;
                    this.color =
                        possibleColors[
                            Math.floor(Math.random() * possibleColors.length)
                        ];
                    this.tilt = Math.floor(Math.random() * 33) - 11;
                    this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
                    this.tiltAngle = 0;

                    this.draw = function () {
                        context.beginPath();
                        context.lineWidth = this.r / 2;
                        context.strokeStyle = this.color;
                        context.moveTo(this.x + this.tilt + this.r / 3, this.y);
                        context.lineTo(
                            this.x + this.tilt,
                            this.y + this.tilt + this.r / 5
                        );
                        return context.stroke();
                    };
                }

                function Draw() {
                    const results = [];

                    // Magical recursive functional love
                    requestAnimationFrame(Draw);

                    context.clearRect(0, 0, W, window.innerHeight);

                    for (var i = 0; i < maxConfettis; i++) {
                        results.push(particles[i].draw());
                    }

                    let particle = {};
                    let remainingFlakes = 0;
                    for (var i = 0; i < maxConfettis; i++) {
                        particle = particles[i];

                        particle.tiltAngle += particle.tiltAngleIncremental;
                        particle.y +=
                            (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
                        particle.tilt =
                            Math.sin(particle.tiltAngle - i / 3) * 15;

                        if (particle.y <= H) remainingFlakes++;

                        // If a confetti has fluttered out of view,
                        // bring it back to above the viewport and let if re-fall.
                        if (
                            particle.x > W + 30 ||
                            particle.x < -30 ||
                            particle.y > H
                        ) {
                            particle.x = Math.random() * W;
                            particle.y = -30;
                            particle.tilt = Math.floor(Math.random() * 10) - 20;
                        }
                    }

                    return results;
                }

                window.addEventListener(
                    "resize",
                    function () {
                        W = window.innerWidth;
                        H = window.innerHeight;
                        canvas.width = window.innerWidth;
                        canvas.height = window.innerHeight;
                    },
                    false
                );

                // Push new confetti objects to `particles[]`
                for (var i = 0; i < maxConfettis; i++) {
                    particles.push(new confettiParticle());
                }

                // Initialize
                canvas.width = W;
                canvas.height = H;
                Draw();

                //winner effect end

                $("#cus_id").val(ids[0][(r[0] / 70 + 1) % ids[0].length | 0]);
                $("#prod_id").val(ids[1][(r[1] / 70 + 1) % ids[1].length | 0]);

                // $('#cus_id').val(reels[0][ (r[0] / 70 + 1) % ids[0].length | 0 ]);
                // $('#prod_id').val(reels[1][ (r[1] / 70 + 1) % ids[1].length | 0 ]);

                setTimeout(saveWinner, 3000);
                spinning = false;
            }

            return { init: init };
        })();

        $(sm.init);
    }

    $("#myTable").DataTable({
        dom: "Bfrtip",
        buttons: ["copy", "csv", "excel", "pdf",{

                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'background', 'white' );

                    // $(win.document.body).find( 'table' )
                    //     .addClass( 'compact' )
                    //     .css( 'font-size', 'inherit' );
                }

        }],
        ordering: false,
    });

    $("#CusTB").DataTable({
        ordering: false,
    });
    $("#productTB").DataTable({
        ordering: false,
    });
});
