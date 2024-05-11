const { useState } = wp.element;

export function App  ()  {
  const [currentDiv, setCurrentDiv] = useState(1);

  const handleContinue = () => {
    if (currentDiv < 3) {
      setCurrentDiv(currentDiv + 1);
    } 
  };
  const handleBack = () => {
    if (currentDiv <= 3) {
      setCurrentDiv(currentDiv - 1);
    } 
  };

  return (
    <div>
      {currentDiv === 1 && (
        <div className="transition-enter">
          <h2>Div 1</h2>
          <button onClick={handleContinue}>Continuer</button>
        </div>
      )}
      {currentDiv === 2 && (
        <div className="transition-enter">
          <h2>Div 2</h2>
          <button onClick={handleContinue}>Continuer</button>
          <button onClick={handleBack}>Retour</button>
        </div>
      )}
      {currentDiv === 3 && (
        <div className="transition-enter">
          <h2>Div 3</h2>
          <button onClick={handleContinue}>Continuer</button>
          <button onClick={handleBack}>Retour</button>
        </div>
      )}
    </div>
  );
};

