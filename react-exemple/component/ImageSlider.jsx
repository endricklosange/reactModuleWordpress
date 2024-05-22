import { Splide, SplideSlide } from '@splidejs/react-splide';
import '@splidejs/react-splide/css';
const { useRef, useEffect, useState } = wp.element;

export function ImageSlider({ title, images, handleContinue, handleBack }) {
    // Calculate the value of perPage based on the number of images
    const perPage = images.length <= 3 ? 3 : 4;
    
    // Create a reference for the Splide instance
    const splideRef = useRef(null);
    
    // State to manage fade animation
    const [loaded, setLoaded] = useState(false);
    const [triggerAnimation, setTriggerAnimation] = useState(false);

    useEffect(() => {
        // Set the state to `true` after mounting to trigger the initial animation
        setLoaded(true);
        setTriggerAnimation(true); // Trigger the initial animation
    }, []);

    const handleButtonClick = (callback) => {
        setTriggerAnimation(false); // Reset the animation
        setTimeout(() => {
            callback(); // Call the callback function (handleContinue or handleBack)
            setTriggerAnimation(true); // Trigger the animation after update
        }, 0);
    };

    // Function to reset the slider position
    const resetSlider = () => {
        if (splideRef.current) {
            splideRef.current.go(0);  // Reset to the first slide
        }
    };

    return (
        <div className="transition-enter">
            <div className="imgSlider">
                <h2>{title}</h2>
                <div className="slider-container">
                    <Splide
                        options={{
                            rewind: true,
                            perPage: perPage
                        }}
                        aria-label="My Favorite Images"
                        ref={splideRef}  // Assign the reference to Splide
                    >
                        {images.map((image, index) => (
                            <SplideSlide key={index}>
                                <div className={`imgCard ${loaded && triggerAnimation ? 'fade-in' : ''}`}>
                                    <h2>{image.label}</h2>
                                    <img src={image.src} alt={image.label} />
                                </div>
                            </SplideSlide>
                        ))}
                    </Splide>
                </div>
            </div>
            <button
                onClick={() => {
                    resetSlider();
                    handleButtonClick(handleContinue);
                }}
            >
                Continue
            </button>
            {handleBack && (
                <button
                    onClick={() => {
                        resetSlider();
                        handleButtonClick(handleBack);
                    }}
                >
                    Back
                </button>
            )}
        </div>
    );
}
