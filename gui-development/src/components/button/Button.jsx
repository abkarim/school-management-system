export default function Button({ children, ...props }) {
  return (
    <button
      type="button"
      className="inline-block w-full p-1 border-2 bg-gradient-to-r border-teal-600 from-teal-500 to-teal-600 rounded-sm transition-colors text-white text-lg  font-semibold font-lato"
      {...props}
    >
      {children}
    </button>
  );
}
