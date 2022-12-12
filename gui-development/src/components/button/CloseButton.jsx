export default function CloseButton({ ...props }) {
  return (
    <button
      type="button"
      className="group bg-white hover:bg-red-500 rounded-full p-1 flex"
      {...props}
    >
      <span className="inline-block bg-img-close-red group-hover:bg-img-close-white bg-no-repeat bg-center p-2"></span>
    </button>
  );
}
