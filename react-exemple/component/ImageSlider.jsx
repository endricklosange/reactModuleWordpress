import { Splide, SplideSlide } from '@splidejs/react-splide';
import '@splidejs/react-splide/css';
const { useRef, useEffect, useState } = wp.element;

function getPerPageValue(imagesLength) {
    const width = window.innerWidth;
    if (width >= 1024) {
        return imagesLength <= 3 ? 3 : 4;
    } else if (width >= 768) {
        return 2;
    } else {
        return 1;
    }
}

export function ImageSlider({ title, images, handleContinue, handleBack, selectedItems, updateSelections, currentDiv }) {
    const splideRef = useRef(null);
    const [perPage, setPerPage] = useState(getPerPageValue(images.length));
    const [loaded, setLoaded] = useState(false);
    const [triggerAnimation, setTriggerAnimation] = useState(false);

    useEffect(() => {
        setLoaded(true);
        setTriggerAnimation(true);

        const handleResize = () => {
            setPerPage(getPerPageValue(images.length));
        };

        setPerPage(getPerPageValue(images.length));

        window.addEventListener('resize', handleResize);

        return () => {
            window.removeEventListener('resize', handleResize);
        };
    }, [images.length]);

    const handleButtonClick = (callback) => {
        setTriggerAnimation(false);

        setTimeout(() => {
            callback();
            setTriggerAnimation(true);
        }, 0);
    };

    const resetSlider = () => {
        if (splideRef.current) {
            splideRef.current.go(0);
        }
    };

    const isMultipleSelection = title === 'Colors' || title === 'Sizes';

    const isIdSelected = (items, id) => {
        for (let item of items) {
            if (Array.isArray(item)) {
                if (isIdSelected(item, id)) {
                    return true;
                }
            } else {
                if (item === id) {
                    return true;
                }
            }
        }
        return false;
    };

    const removeIdFromItems = (items, id) => {
        return items
            .map(item => {
                if (Array.isArray(item)) {
                    const filteredItem = removeIdFromItems(item, id);
                    return filteredItem.length > 0 ? filteredItem : null;
                }
                return item !== id ? item : null;
            })
            .filter(item => item !== null);
    };

    const handleImageClick = (imageLabel, imageId) => {
        let updatedSelection;
    
        if (isMultipleSelection) {
            if (isIdSelected(selectedItems, imageId)) {
                console.log('already selected');
                updatedSelection = selectedItems.filter(id => id !== imageId);
            } else {
                updatedSelection =  imageId ;
            }
        } else {
            updatedSelection = {
                id: imageId,
                label: imageLabel
            };
        }
    
        updateSelections(updatedSelection);
        console.log('selectedItems',(selectedItems));
        console.log('updatedSelection', updatedSelection);
    };

    return (
        <div className="transition-enter">
            <div className="imgSlider">
                <h2>{title}</h2>
                <div className="slider-container">
                    <Splide
                        options={{
                            rewind: true,
                            perPage: perPage,
                            perMove: 1,
                        }}
                        aria-label="Image Slider"
                        ref={splideRef}
                    >
                        {images.map((image, index) => (
                            <SplideSlide key={index}>
                                <div
                                    className={`imgCard ${triggerAnimation ? 'fade-in' : ''} ${selectedItems.includes(image.id) ? 'selected' : ''}`}
                                    onClick={() => handleImageClick(image.label, image.id)}
                                >
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
                    if (selectedItems.length > 0) {
                        resetSlider();
                        handleButtonClick(handleContinue);
                    } else {
                        // alert("Please select at least one item to continue.");
                    }
                }}
                disabled={selectedItems.length === 0}
            >
                Continue
            </button>
            {currentDiv !== 0 && handleBack && (
                <button
                    onClick={() => {
                        resetSlider();
                        handleButtonClick(handleBack);
                    }}
                >
                    Retour
                </button>
            )}
        </div>
    );
}
