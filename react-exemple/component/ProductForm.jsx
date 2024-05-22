export function ProductForm({ handleContinue, handleBack }) {
    return (
      <div className="transition-enter">
        <h2>Div 6</h2>
        <div className="form">
          <h2>Nom du produit</h2>
          <span>Veuillez spécifier le nom du produit que vous recherchez</span>
          <label htmlFor="name"></label>
          <input type="text" placeholder="Entrez le nom du produit..." id="name" />
        </div>
        <button onClick={handleContinue}>Valider</button>
        <button onClick={handleBack}>Retour</button>
      </div>
    );
  }