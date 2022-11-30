export default function EmailInput({ ...props }) {
    return (
      <input
        type="email"
        className="bg-slate-100 border-gray-500  border-2 p-1 rounded-sm w-full focus:border-gray-800 text-lg text-gray-900"
        {...props}
      />
    );
  }
  