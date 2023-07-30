import { screen, render } from '@testing-library/vue';
import VehicleSearch from '../components/VehicleSearch.vue';

test('it should work', () => {
    render(VehicleSearch, {});
    expect(screen.queryByText('Make')).toBeTruthy()
    expect(screen.queryByText('Model')).toBeTruthy()
    expect(screen.queryByText('Registration')).toBeTruthy()
    expect(screen.queryByText('Submit')).toBeTruthy()
    expect(screen.queryByText('Clear')).toBeTruthy()
})
